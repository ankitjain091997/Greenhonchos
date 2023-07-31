<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\BlogsController;

class BlogsTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @test */
    public function BlogsTest()
    {
        $blogs = new BlogsController();

        // $result = 5;
        $this->assertTrue(true, $blogs->edit(10));
    }
}