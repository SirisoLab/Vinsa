<?php

namespace Tests\Feature;

use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use App\Models\Category;
use App\Models\History;
use App\Models\Product;
use App\Models\Type;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MasterCategoryTypeTest extends TestCase
{
    use RefreshDatabase;

    protected function makeAdmin(): User
    {
        return User::factory()->create();
    }

    public function test_guest_cannot_access_category_or_type_routes(): void
    {
        $category = Category::create(['name' => 'Push Button']);
        $type = Type::create(['category_id' => $category->id, 'name' => 'Flush']);

        $this->get(route('categories.index'))->assertNotFound();
        $this->post(route('categories.store'), ['name' => 'Unauthorized'])->assertNotFound();
        $this->get(route('categories.show', $category))->assertNotFound();
        $this->put(route('categories.update', $category), ['name' => 'Changed'])->assertNotFound();
        $this->delete(route('categories.destroy', $category))->assertNotFound();
        $this->post(route('categories.types.store', $category), ['name' => 'Unauthorized'])->assertNotFound();
        $this->get(route('categories.types.json', $category))->assertNotFound();

        $this->get(route('types.index'))->assertNotFound();
        $this->post(route('types.store'), ['category_id' => $category->id, 'name' => 'Unauthorized'])->assertNotFound();
        $this->put(route('types.update', $type), ['name' => 'Changed'])->assertNotFound();
        $this->delete(route('types.destroy', $type))->assertNotFound();
    }

    public function test_authenticated_admin_sees_categories_and_types_navigation_and_dashboard_stats(): void
    {
        $user = $this->makeAdmin();
        $cat = Category::create(['name' => 'Contactor']);
        Type::create(['category_id' => $cat->id, 'name' => 'AC Coil']);
        Type::create(['category_id' => $cat->id, 'name' => 'DC Coil']);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee(__('Master Categories'));
        $response->assertSee(__('Master Types'));
        $response->assertSee('Categories · 2 Types');

        // Master Categories page also renders category cards and quick add actions
        $this->actingAs($user)
            ->get(route('categories.index'))
            ->assertOk()
            ->assertSee('Contactor')
            ->assertSee('AC Coil')
            ->assertSee('DC Coil');
    }

    public function test_category_crud_validation_history_and_cache_invalidation(): void
    {
        $user = $this->makeAdmin();

        Cache::put('homepage_categories_tree', ['stale'], 3600);
        Cache::put('all_categories_nav', ['stale'], 3600);

        // Blank rejected
        $this->actingAs($user)
            ->from(route('categories.index'))
            ->post(route('categories.store'), ['name' => '   '])
            ->assertSessionHasErrors('name');

        // Create with whitespace trim
        $this->actingAs($user)
            ->post(route('categories.store'), ['name' => '  Push Button  '])
            ->assertRedirect(route('categories.index'))
            ->assertSessionHas('success');

        $category = Category::where('name', 'Push Button')->firstOrFail();
        $this->assertFalse(Cache::has('homepage_categories_tree'));
        $this->assertFalse(Cache::has('all_categories_nav'));
        $this->assertDatabaseHas('histories', [
            'user_id' => $user->id,
            'action' => 'create',
            'entity_type' => 'category',
            'entity_id' => $category->id,
        ]);

        // Case-insensitive duplicate rejected
        $this->actingAs($user)
            ->from(route('categories.index'))
            ->post(route('categories.store'), ['name' => 'push button'])
            ->assertSessionHasErrors('name');

        // Another category + case-insensitive collision on update rejected
        $other = Category::create(['name' => 'Selector Switch']);
        $this->actingAs($user)
            ->from(route('categories.index'))
            ->put(route('categories.update', $other), ['name' => 'PUSH BUTTON'])
            ->assertSessionHasErrors('name');

        // Valid update
        Cache::put('homepage_categories_tree', ['stale'], 3600);
        Cache::put('all_categories_nav', ['stale'], 3600);
        $this->actingAs($user)
            ->put(route('categories.update', $category), ['name' => 'Push Button Updated'])
            ->assertRedirect(route('categories.index'))
            ->assertSessionHas('success');

        $this->assertSame('Push Button Updated', $category->fresh()->name);
        $this->assertFalse(Cache::has('homepage_categories_tree'));
        $this->assertFalse(Cache::has('all_categories_nav'));
        $this->assertDatabaseHas('histories', [
            'action' => 'update',
            'entity_type' => 'category',
            'entity_id' => $category->id,
        ]);

        // Empty child type deleted when empty category is deleted
        $emptyChildType = Type::create(['category_id' => $category->id, 'name' => 'Orphaned Check']);
        Cache::put('homepage_categories_tree', ['stale'], 3600);

        $this->actingAs($user)
            ->delete(route('categories.destroy', $category))
            ->assertRedirect(route('categories.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
        $this->assertDatabaseMissing('types', ['id' => $emptyChildType->id]);
        $this->assertFalse(Cache::has('homepage_categories_tree'));
        $this->assertDatabaseHas('histories', [
            'action' => 'delete',
            'entity_type' => 'category',
            'entity_id' => $category->id,
        ]);
    }

    public function test_cannot_delete_category_that_still_has_products(): void
    {
        $user = $this->makeAdmin();
        $category = Category::create(['name' => 'Box Panel']);
        Product::create([
            'name' => 'Box Panel 40x60',
            'kode' => 'BP-4060',
            'category_id' => $category->id,
            'image' => 'default.png',
        ]);

        $this->actingAs($user)
            ->delete(route('categories.destroy', $category))
            ->assertRedirect(route('categories.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_type_crud_inside_category_and_scoped_uniqueness(): void
    {
        $user = $this->makeAdmin();
        $pushButton = Category::create(['name' => 'Push Button']);
        $selectorSwitch = Category::create(['name' => 'Selector Switch']);

        $this->actingAs($user)
            ->get(route('categories.show', $pushButton))
            ->assertOk()
            ->assertSee('Tambah Type di dalam "Push Button"', false);

        Cache::put('homepage_categories_tree', ['stale'], 3600);
        Cache::put('all_categories_nav', ['stale'], 3600);

        // Add Type inside Push Button
        $this->actingAs($user)
            ->post(route('categories.types.store', $pushButton), ['name' => '  Standard  '])
            ->assertRedirect(route('categories.show', $pushButton))
            ->assertSessionHas('success');

        $typeInPushButton = Type::where('category_id', $pushButton->id)
            ->where('name', 'Standard')
            ->firstOrFail();

        $this->assertFalse(Cache::has('homepage_categories_tree'));
        $this->assertFalse(Cache::has('all_categories_nav'));
        $this->assertDatabaseHas('histories', [
            'action' => 'create',
            'entity_type' => 'type',
            'entity_id' => $typeInPushButton->id,
        ]);

        // Duplicate (case-insensitive) inside SAME category rejected
        $this->actingAs($user)
            ->from(route('categories.show', $pushButton))
            ->post(route('categories.types.store', $pushButton), ['name' => 'standard'])
            ->assertSessionHasErrors('name');

        // Same name inside DIFFERENT category allowed
        $this->actingAs($user)
            ->post(route('categories.types.store', $selectorSwitch), ['name' => 'Standard'])
            ->assertRedirect(route('categories.show', $selectorSwitch))
            ->assertSessionHas('success');

        $this->assertDatabaseCount('types', 2);

        // Category detail page renders its own type and does not confuse counts
        $this->actingAs($user)
            ->get(route('categories.show', $pushButton))
            ->assertOk()
            ->assertSee('Standard')
            ->assertSee('Daftar Type (1)');
    }

    public function test_global_type_index_filtering_creation_and_category_requirement(): void
    {
        $user = $this->makeAdmin();
        $catA = Category::create(['name' => 'MCCB']);
        $catB = Category::create(['name' => 'Pilot Lamp']);

        // Missing category_id must fail
        $this->actingAs($user)
            ->from(route('types.index'))
            ->post(route('types.store'), ['name' => 'Floating Type'])
            ->assertSessionHasErrors('category_id');

        $this->assertDatabaseCount('types', 0);

        // Create via global types page with required category_id
        $this->actingAs($user)
            ->post(route('types.store'), [
                'category_id' => $catA->id,
                'name' => 'Thermal Magnetic',
            ])
            ->assertRedirect(route('types.index', ['category_id' => $catA->id]))
            ->assertSessionHas('success');

        Type::create(['category_id' => $catB->id, 'name' => 'LED 220V']);

        $this->actingAs($user)
            ->get(route('types.index', ['category_id' => $catA->id]))
            ->assertOk()
            ->assertSee('Thermal Magnetic')
            ->assertDontSee('LED 220V');

        $this->actingAs($user)
            ->get(route('types.index', ['search' => 'LED']))
            ->assertOk()
            ->assertSee('LED 220V')
            ->assertDontSee('Thermal Magnetic');
    }

    public function test_cannot_delete_or_reassign_type_with_products(): void
    {
        $user = $this->makeAdmin();
        $catA = Category::create(['name' => 'Push Button']);
        $catB = Category::create(['name' => 'Emergency Push Button']);
        $type = Type::create(['category_id' => $catA->id, 'name' => 'Flush']);

        $product = Product::create([
            'name' => 'PB Flush Green',
            'kode' => 'PB-FG-01',
            'category_id' => $catA->id,
            'type_id' => $type->id,
            'image' => 'default.png',
        ]);

        // Delete blocked while products exist
        $this->actingAs($user)
            ->delete(route('types.destroy', $type), ['_origin' => 'category_show'])
            ->assertRedirect(route('categories.show', $catA->id))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('types', ['id' => $type->id]);

        // Moving category blocked while products exist
        $this->actingAs($user)
            ->from(route('categories.show', $catA->id))
            ->put(route('types.update', $type), [
                '_origin' => 'category_show',
                'category_id' => $catB->id,
                'name' => 'Flush',
            ])
            ->assertSessionHasErrors('category_id');

        $this->assertSame($catA->id, $type->fresh()->category_id);

        // Renaming inside the SAME category allowed even when products exist
        $this->actingAs($user)
            ->put(route('types.update', $type), [
                '_origin' => 'category_show',
                'category_id' => $catA->id,
                'name' => 'Flush Renamed',
            ])
            ->assertRedirect(route('categories.show', $catA->id))
            ->assertSessionHas('success');

        $this->assertSame('Flush Renamed', $type->fresh()->name);

        // Detach product, now delete succeeds
        $product->delete();
        $this->actingAs($user)
            ->delete(route('types.destroy', $type), ['_origin' => 'category_show'])
            ->assertRedirect(route('categories.show', $catA->id))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('types', ['id' => $type->id]);
    }

    public function test_category_types_json_returns_only_types_inside_requested_category(): void
    {
        $user = $this->makeAdmin();
        $cat1 = Category::create(['name' => 'Cable Lug']);
        $cat2 = Category::create(['name' => 'Terminal Block']);

        Type::create(['category_id' => $cat1->id, 'name' => 'Z-Type']);
        Type::create(['category_id' => $cat1->id, 'name' => 'A-Type']);
        Type::create(['category_id' => $cat2->id, 'name' => 'Foreign Type']);

        $response = $this->actingAs($user)->getJson(route('categories.types.json', $cat1));

        $response->assertOk()
            ->assertJson([
                'category_id' => $cat1->id,
                'category_name' => 'Cable Lug',
            ]);

        $types = $response->json('types');
        $this->assertCount(2, $types);
        $this->assertSame(['A-Type', 'Z-Type'], array_column($types, 'name'));
    }

    public function test_product_create_and_update_enforce_type_belongs_to_selected_category_and_preserve_series(): void
    {
        $user = $this->makeAdmin();
        $pushButton = Category::create(['name' => 'Push Button']);
        $selectorSwitch = Category::create(['name' => 'Selector Switch']);

        $pbType = Type::create(['category_id' => $pushButton->id, 'name' => 'Flush Green']);
        $ssType = Type::create(['category_id' => $selectorSwitch->id, 'name' => 'Rotary 2 Pos']);

        // Form page loads
        $this->actingAs($user)
            ->get(route('products.view'))
            ->assertOk()
            ->assertSee('id="typeSelect"', false)
            ->assertSee('Flush Green');

        // Reject creating product with type from DIFFERENT category
        $this->actingAs($user)
            ->from(route('products.view'))
            ->post(route('products.store'), [
                'name' => 'Mismatched Product',
                'kode' => 'MIS-001',
                'category_id' => $pushButton->id,
                'type_id' => $ssType->id,
                'image_link' => 'https://example.com/img.jpg',
            ])
            ->assertSessionHasErrors('type_id');

        $this->assertDatabaseMissing('products', ['kode' => 'MIS-001']);

        // Valid create with matching category & type + series preserved in custom_input
        $this->actingAs($user)
            ->post(route('products.store'), [
                'name' => 'Vinsa PB Flush Green',
                'kode' => 'KB5-FG-01',
                'category_id' => $pushButton->id,
                'type_id' => $pbType->id,
                'push_button_series' => 'KB 5 Series',
                'image_link' => 'https://example.com/pb.jpg',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $product = Product::where('kode', 'KB5-FG-01')->firstOrFail();
        $this->assertSame($pushButton->id, $product->category_id);
        $this->assertSame($pbType->id, $product->type_id);
        $decodedCustom = json_decode($product->custom_input, true);
        $this->assertSame(['series' => 'KB 5 Series'], $decodedCustom);

        // Edit view loads
        $this->actingAs($user)
            ->get(route('products.editss', $product->id))
            ->assertOk()
            ->assertSee('id="typeSelect"', false)
            ->assertSee('KB 5 Series');

        // Reject update with mismatched type across categories
        $this->actingAs($user)
            ->from(route('products.editss', $product->id))
            ->put(route('products.update', $product->id), [
                'name' => 'Vinsa SS Updated',
                'kode' => 'KB5-FG-01',
                'category_id' => $selectorSwitch->id,
                'type_id' => $pbType->id,
            ])
            ->assertSessionHasErrors('type_id');

        $this->assertSame($pushButton->id, $product->fresh()->category_id);

        // Valid update to Selector Switch + valid ssType
        $this->actingAs($user)
            ->put(route('products.update', $product->id), [
                'name' => 'Vinsa SS Updated',
                'kode' => 'KB5-FG-01',
                'category_id' => $selectorSwitch->id,
                'type_id' => $ssType->id,
                'custom_input' => json_encode(['series' => 'KB 2 Series']),
            ])
            ->assertRedirect(route('products.edit'))
            ->assertSessionHas('success');

        $product->refresh();
        $this->assertSame($selectorSwitch->id, $product->category_id);
        $this->assertSame($ssType->id, $product->type_id);
        $this->assertSame('Rotary 2 Pos', $product->resolvedTypeName());
        $this->assertDatabaseHas('histories', [
            'action' => 'update',
            'entity_type' => 'product',
            'entity_id' => $product->id,
        ]);

        // Legacy product hint displayed cleanly on edit page when type_id is null
        $legacyProduct = Product::create([
            'name' => 'Legacy PB',
            'kode' => 'LEG-001',
            'category_id' => $pushButton->id,
            'type_id' => null,
            'custom_input' => json_encode(['tipe' => 'Extended Head', 'series' => 'KB 2 Series']),
            'image' => 'default.png',
        ]);

        $this->actingAs($user)
            ->get(route('products.editss', $legacyProduct->id))
            ->assertOk()
            ->assertSee('Legacy Type tercatat:')
            ->assertSee('Extended Head');
    }

    public function test_admin_product_list_displays_and_searches_by_type(): void
    {
        $user = $this->makeAdmin();
        $cat = Category::create(['name' => 'Emergency Push Button']);
        $type = Type::create(['category_id' => $cat->id, 'name' => 'Mushroom Turn Release']);

        Product::create([
            'name' => 'Emergency Stop 40mm',
            'kode' => 'ES-40',
            'category_id' => $cat->id,
            'type_id' => $type->id,
            'image' => 'default.png',
        ]);

        Product::create([
            'name' => 'Unrelated Item',
            'kode' => 'UNR-01',
            'category_id' => $cat->id,
            'image' => 'default.png',
        ]);

        $response = $this->actingAs($user)->get(route('products.edit', ['search' => 'Mushroom Turn']));

        $response->assertOk()
            ->assertSee('Emergency Stop 40mm')
            ->assertSee('Type: Mushroom Turn Release')
            ->assertDontSee('Unrelated Item');
    }

    public function test_products_import_and_export_resolve_type_inside_category(): void
    {
        $import = new ProductsImport();

        $rows = new Collection([
            [
                'kode' => 'IMP-PB-01',
                'name' => 'Imported Push Button',
                'description' => 'Desc 1',
                'stock' => 10,
                'category' => 'Push Button',
                'type' => 'Illuminated Green',
                'series' => 'KB 5 Series',
                'specifications' => 'Voltage:220V|Contact:1NO',
            ],
            [
                'kode' => 'IMP-SS-01',
                'name' => 'Imported Selector Switch',
                'description' => 'Desc 2',
                'stock' => 5,
                'category' => 'Selector Switch',
                'type' => 'Illuminated Green',
                'series' => 'KB 2 Series',
                'specifications' => '',
            ],
        ]);

        $import->collection($rows);

        $this->assertSame(2, $import->created);
        $this->assertSame([], $import->errors);

        $pbCat = Category::where('name', 'Push Button')->firstOrFail();
        $ssCat = Category::where('name', 'Selector Switch')->firstOrFail();

        $pbType = Type::where('category_id', $pbCat->id)->where('name', 'Illuminated Green')->firstOrFail();
        $ssType = Type::where('category_id', $ssCat->id)->where('name', 'Illuminated Green')->firstOrFail();
        $this->assertNotSame($pbType->id, $ssType->id);

        $p1 = Product::where('kode', 'IMP-PB-01')->firstOrFail();
        $this->assertSame($pbType->id, $p1->type_id);
        $this->assertSame(['series' => 'KB 5 Series'], json_decode($p1->custom_input, true));

        // Now update IMP-PB-01 moving category to MCCB with blank type => clears stale type_id cleanly
        $import2 = new ProductsImport();
        $import2->collection(new Collection([
            [
                'kode' => 'IMP-PB-01',
                'name' => 'Moved to MCCB',
                'category' => 'MCCB',
                'type' => '',
                'series' => 'M12B 25kA',
            ],
        ]));

        $p1->refresh();
        $this->assertSame('Moved to MCCB', $p1->name);
        $this->assertNull($p1->type_id);

        // Verify Export maps master type & series + legacy fallback cleanly
        $p2 = Product::with(['category', 'type', 'attributes'])->where('kode', 'IMP-SS-01')->firstOrFail();
        $legacy = Product::create([
            'name' => 'Legacy Pilot',
            'kode' => 'PIL-LEG',
            'category_id' => Category::create(['name' => 'Pilot Lamp'])->id,
            'type_id' => null,
            'custom_input' => json_encode(['value' => 'Neon Red']),
            'image' => 'default.png',
        ]);
        $legacy->load(['category', 'type', 'attributes']);

        $export = new ProductsExport();
        $mappedNew = $export->map($p2);
        $mappedLegacy = $export->map($legacy);

        $this->assertSame('Selector Switch', $mappedNew[4]);
        $this->assertSame('Illuminated Green', $mappedNew[5]);
        $this->assertSame('KB 2 Series', $mappedNew[6]);

        $this->assertSame('Pilot Lamp', $mappedLegacy[4]);
        $this->assertSame('Neon Red', $mappedLegacy[5]);
    }

    public function test_public_catalog_filters_by_type_within_category_and_detail_renders_type(): void
    {
        $pb = Category::create(['name' => 'Push Button']);
        $flush = Type::create(['category_id' => $pb->id, 'name' => 'Flush']);
        $mushroom = Type::create(['category_id' => $pb->id, 'name' => 'Mushroom']);

        $pFlush = Product::create([
            'name' => 'Vinsa PB Flush',
            'kode' => 'PB-FL-1',
            'category_id' => $pb->id,
            'type_id' => $flush->id,
            'image' => 'default.png',
        ]);
        $pMushroom = Product::create([
            'name' => 'Vinsa PB Mushroom',
            'kode' => 'PB-MS-1',
            'category_id' => $pb->id,
            'type_id' => $mushroom->id,
            'image' => 'default.png',
        ]);

        $pilotCat = Category::create(['name' => 'Pilot Lamp']);
        $legacyPilot = Product::create([
            'name' => 'Vinsa Pilot Lamp',
            'kode' => 'PL-220',
            'category_id' => $pilotCat->id,
            'type_id' => null,
            'custom_input' => json_encode(['value' => '220V LED']),
            'image' => 'default.png',
        ]);

        // Category view shows type filter chips + both products
        $this->get('/product/push-button')
            ->assertOk()
            ->assertSee(__('All Types'))
            ->assertSee('Flush')
            ->assertSee('Mushroom')
            ->assertSee('Vinsa PB Flush')
            ->assertSee('Vinsa PB Mushroom');

        // Filtered by type=mushroom returns only Mushroom
        $this->get('/product/push-button?type=mushroom')
            ->assertOk()
            ->assertSee('Vinsa PB Mushroom')
            ->assertDontSee('Vinsa PB Flush');

        // Unknown type returns empty cleanly
        $this->get('/product/push-button?type=nonexistent')
            ->assertOk()
            ->assertDontSee('Vinsa PB Mushroom')
            ->assertDontSee('Vinsa PB Flush');

        // Detail page shows master type cleanly
        $this->get(route('product.show', $pMushroom->slug))
            ->assertOk()
            ->assertSee('Vinsa PB Mushroom')
            ->assertSee('Mushroom');

        // Legacy detail page renders clean value without raw JSON braces
        $this->get(route('product.show', $legacyPilot->slug))
            ->assertOk()
            ->assertSee('- 220V LED')
            ->assertDontSee('{"value":"220V LED"}');

        // Public all-products page & homepage render cleanly with Master Categories/Types seeded
        $this->get('/product')->assertOk();
        $this->get('/')
            ->assertOk()
            ->assertSee('Vinsa PB Flush')
            ->assertSee('Vinsa PB Mushroom');
    }

    public function test_global_type_update_and_import_export_pages_work(): void
    {
        $user = $this->makeAdmin();
        $catA = Category::create(['name' => 'Panel Box']);
        $catB = Category::create(['name' => 'Cable Tray']);
        $type = Type::create(['category_id' => $catA->id, 'name' => 'Indoor']);

        // Move unused type across categories from types.index
        $this->actingAs($user)
            ->put(route('types.update', $type), [
                '_origin' => 'types_index',
                'category_id' => $catB->id,
                'name' => 'Perforated',
            ])
            ->assertRedirect(route('types.index'))
            ->assertSessionHas('success');

        $type->refresh();
        $this->assertSame($catB->id, $type->category_id);
        $this->assertSame('Perforated', $type->name);

        // Import view and Excel export template download respond cleanly
        $this->actingAs($user)
            ->get(route('products.import.view'))
            ->assertOk()
            ->assertSee('Categories &amp; Types', false);

        $this->actingAs($user)
            ->get(route('products.export.template'))
            ->assertOk();
    }

    public function test_migrations_roll_back_cleanly_and_reapply(): void
    {
        $this->assertTrue(Schema::hasTable('types'));
        $this->assertTrue(Schema::hasColumn('products', 'type_id'));

        Artisan::call('migrate:rollback', ['--step' => 2]);

        $this->assertFalse(Schema::hasColumn('products', 'type_id'));
        $this->assertFalse(Schema::hasTable('types'));

        Artisan::call('migrate');

        $this->assertTrue(Schema::hasTable('types'));
        $this->assertTrue(Schema::hasColumn('products', 'type_id'));
    }

    public function test_homepage_renders_category_types_dynamically_in_creation_order_with_horizontal_slider(): void
    {
        $user = $this->makeAdmin();
        $boxPanel = Category::create(['name' => 'Box Panel']);

        // Create Wall Mounting BEFORE Free Standing so alphabetical ordering would flip them
        $wallMounting = Type::create(['category_id' => $boxPanel->id, 'name' => 'Box Panel Wall Mounting IP65']);
        $freeStanding = Type::create(['category_id' => $boxPanel->id, 'name' => 'Box Panel Free Standing IP55']);

        Product::create([
            'name' => 'Box Panel 25 x 20 x 15 Wall Mounting',
            'kode' => 'VHB252015',
            'category_id' => $boxPanel->id,
            'type_id' => $wallMounting->id,
            'image' => 'default.png',
        ]);

        Product::create([
            'name' => 'Box Panel 200 x 80 x 60 Free Standing',
            'kode' => 'VHB2008060',
            'category_id' => $boxPanel->id,
            'type_id' => $freeStanding->id,
            'image' => 'default.png',
        ]);

        Product::create([
            'name' => 'Box Panel Custom Untyped',
            'kode' => 'VHB-CUSTOM',
            'category_id' => $boxPanel->id,
            'type_id' => null,
            'custom_input' => json_encode(['value' => 'Custom Mount']),
            'image' => 'default.png',
        ]);

        $response = $this->get('/');
        $response->assertOk()
            ->assertSee('group/outer-slider', false)
            ->assertSee('outer-slider-btn', false)
            ->assertSee('scrollSlider(this, -1)', false)
            ->assertSee('scrollSlider(this, 1)', false)
            ->assertSee('/product/box-panel?type=box-panel-wall-mounting-ip65', false)
            ->assertSee('/product/box-panel?type=box-panel-free-standing-ip55', false)
            ->assertSee('Box Panel Wall Mounting IP65')
            ->assertSee('Box Panel Free Standing IP55')
            ->assertSee(__('Other Types'))
            ->assertSee('VHB252015')
            ->assertSee('VHB2008060')
            ->assertSee('VHB-CUSTOM');

        $html = $response->getContent();
        $posWall = strpos($html, 'Box Panel Wall Mounting IP65');
        $posFree = strpos($html, 'Box Panel Free Standing IP55');
        $posOther = strpos($html, __('Other Types'));
        $this->assertNotFalse($posWall);
        $this->assertNotFalse($posFree);
        $this->assertNotFalse($posOther);
        $this->assertLessThan($posFree, $posWall);
        $this->assertLessThan($posOther, $posFree);

        // Dynamically add a 3rd Type in Backoffice => invalidates cache & appears immediately on homepage
        $this->assertTrue(Cache::has('homepage_categories_tree'));

        $this->actingAs($user)
            ->post(route('categories.types.store', $boxPanel), ['name' => 'Box Panel Outdoor IP66'])
            ->assertRedirect(route('categories.show', $boxPanel))
            ->assertSessionHas('success');

        $this->assertFalse(Cache::has('homepage_categories_tree'));

        $afterAdd = $this->get('/');
        $afterAdd->assertOk()
            ->assertSee('Box Panel Outdoor IP66')
            ->assertSee('/product/box-panel?type=box-panel-outdoor-ip66', false)
            ->assertSee(__('No products available.'));

        $afterHtml = $afterAdd->getContent();
        $this->assertLessThan(
            strpos($afterHtml, 'Box Panel Outdoor IP66'),
            strpos($afterHtml, 'Box Panel Free Standing IP55')
        );
        $this->assertLessThan(
            strpos($afterHtml, __('Other Types')),
            strpos($afterHtml, 'Box Panel Outdoor IP66')
        );

        // Single-type category renders full width outer panel without hiding inner product slider arrows
        $terminalBlock = Category::create(['name' => 'Terminal Block']);
        $singleType = Type::create(['category_id' => $terminalBlock->id, 'name' => 'DIN Rail TB']);
        for ($i = 1; $i <= 3; $i++) {
            Product::create([
                'name' => "Terminal Block {$i}",
                'kode' => "TB-0{$i}",
                'category_id' => $terminalBlock->id,
                'type_id' => $singleType->id,
                'image' => 'default.png',
            ]);
        }

        $singleResponse = $this->get('/');
        $singleResponse->assertOk()
            ->assertSee('DIN Rail TB')
            ->assertSee('snap-start flex-shrink-0 w-full text-white', false);
    }

    public function test_homepage_keeps_legacy_layout_when_category_has_no_master_types(): void
    {
        $boxPanel = Category::create(['name' => 'Box Panel']);

        Product::create([
            'name' => 'Legacy Wall Box',
            'kode' => 'VHB302015',
            'category_id' => $boxPanel->id,
            'type_id' => null,
            'image' => 'default.png',
        ]);

        Product::create([
            'name' => 'Legacy Free Box',
            'kode' => 'VHB2008060',
            'category_id' => $boxPanel->id,
            'type_id' => null,
            'image' => 'default.png',
        ]);

        $response = $this->get('/');
        $response->assertOk()
            ->assertSee('Box Panel Wall Mounting IP65')
            ->assertSee('Box Panel Free Standing IP55')
            ->assertSee('VHB302015')
            ->assertSee('VHB2008060')
            ->assertSee('grid grid-cols-1 md:grid-cols-2 gap-4 mt-4', false)
            ->assertDontSee('aria-label="Geser type ke kiri"', false);
    }
}
