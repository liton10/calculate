<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
Use App\Product;

class ProductTest extends TestCase
{
	use RefreshDatabase;

    /**
     * Test to insert product.
     *
     * @return void
     */
    public function testProducts()
    {
    	Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');

        // Checking product adding.
    	$response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/add', ['name' => 'TestProd', 'description' => 'TestDesc','price' => 123.00, 'select_file' => $file]);
        $response->assertStatus(200);
        $response->assertSeeText('TestProd');

        // Now that we have product added, it should find product in product listting as well.
        $response = $this->get('/');
        $response->assertSeeText('TestProd');
        $response->assertStatus(200);

        // We will update the added product to see whether update works.
        $product = Product::orderBy('created_at', 'desc')->first();

        // Checking product adding.
        $this->followingRedirects();
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/productEdit/'.$product->id, ['name' => 'TestProdEdited', 'description' => 'TestDesc','price' => 123.00]);
        $response->assertStatus(200);
        $response->assertSeeText('TestProdEdited');
        
        // Now we will delete the product
        $response = $this->get('/delete/'.$product->id);
        $responseBody = json_decode($response->getContent(), true);
        $response->assertStatus(200);
        $this->assertEquals('OK', $responseBody['message']);
    }
}
