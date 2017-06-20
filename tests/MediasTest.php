<?php

use EscapeWork\LaraMedias\Events\MediaAdded;
use EscapeWork\LaraMedias\Models\Media;

class MediasTest extends TestCase
{
    /** @test */
    public function it_should_upload_media()
    {
        $product = new Product();
        $product->id = 1;

        $product->uploadMultipleMedias([$this->getPicture()]);
        $this->assertEquals(1, Media::count());
        $this->assertEquals(1, $product->medias->count());

        Event::assertDispatched(MediaAdded::class);
    }

    /** @test */
    public function it_should_upload_multiple_medias()
    {
        $product = new Product();
        $product->id = 1;

        $product->uploadMultipleMedias([$this->getPicture(), $this->getPicture()]);
        $this->assertEquals(2, Media::count());
        $this->assertEquals(2, $product->medias->count());

        Event::assertDispatched(MediaAdded::class);
        Event::assertDispatched(MediaAdded::class);
    }

    /** @test */
    public function it_should_upload_single_media()
    {
        config()->set('medias.models', [
            'products' => [
                'model'  => 'Product',
                'fields' => ['cover'],
            ],
        ]);

        $product = new Product();
        $product->id = 1;

        $product->uploadSingleMedia($this->getPicture(), 'cover');
        $product->save();

        $this->assertNotNull(Product::find(1)->cover);

        Event::assertNotDispatched(MediaAdded::class);
    }
}
