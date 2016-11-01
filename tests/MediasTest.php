<?php

class MediasTest extends TestCase
{
    /** @test */
    public function it_should_upload_media()
    {
        $product = new Product();
        $product->id = 1;

        $product->uploadMultipleMedias([$this->getPicture()]);
        $this->seeInDatabase('laramedias', ['model_id' => $product->id]);
        $this->assertEquals(1, $product->medias->count());
    }

    /** @test */
    public function it_should_upload_multiple_medias()
    {
        $product = new Product();
        $product->id = 1;

        $product->uploadMultipleMedias([$this->getPicture(), $this->getPicture()]);
        $this->seeInDatabase('laramedias', ['model_id' => $product->id]);
        $this->assertEquals(2, $product->medias->count());
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
    }
}
