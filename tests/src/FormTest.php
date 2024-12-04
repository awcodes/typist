<?php

use Awcodes\Typist\Support\Faker;
use Awcodes\Typist\Tests\Fixtures\TestComponent;
use Awcodes\Typist\Tests\Models\Page;
use function Pest\Livewire\livewire;

it('can render form component', function () {
    livewire(TestComponent::class)
        ->assertFormFieldExists('content')
        ->assertSee('typist-wrapper')
        ->assertSee('typist-editor');
});

it('can save correct form data', function () {
    $page = Page::factory()->withContent()->make();

    livewire(TestComponent::class)
        ->fillForm([
            'title' => $page->title,
            'slug' => $page->slug,
            'content' => $page->content,
        ])
        ->assertFormSet([
            'content' => $page->content,
        ])
        ->call('save')
        ->assertHasNoFormErrors()
        ->assertSet('data.content', $page->content);

    $this->assertDatabaseHas(Page::class, [
        'content' => json_encode($page->content),
    ]);
});

it('can update correct form data', function () {
    $page = Page::factory()->withContent()->create();
    $newContent = Faker::make()->heading()->paragraphs()->asJson();

    livewire(TestComponent::class)
        ->fillForm([
            'title' => $page->title,
            'slug' => $page->slug,
            'content' => $page->content,
        ])
        ->assertFormSet([
            'content' => $page->content,
        ])
        ->fillForm([
            'content' => $newContent,
        ])
        ->call('update')
        ->assertHasNoFormErrors()
        ->assertSet('data.content', $newContent);

    expect($page->refresh())
        ->content->toBe($newContent);
});
