<?php

use App\Models\User;
use App\Models\Review;
use App\Policies\ReviewPolicy;

uses()->group('unit', 'policies');

/** @var \App\Policies\ReviewPolicy $policy */
$policy = new ReviewPolicy;

it('denies librarians from creating reviews', function () use ($policy) {
    $librarian = new User(['role' => 'librarian']);
    expect($policy->create($librarian))->toBeFalse();
});

it('allows customers to create reviews', function () use ($policy) {
    $customer = new User(['role' => 'customer']);
    expect($policy->create($customer))->toBeTrue();
});

it('denies non-customers from creating reviews', function () use ($policy) {
    $guest = new User(['role' => 'foo']);
    expect($policy->create($guest))->toBeFalse();
});

it('allows a customer to update their own review', function () use ($policy) {
    $customer = new User(['role' => 'customer']);
    $customer->id = 42;

    $review = new Review(['user_id' => 42]);
    expect($policy->update($customer, $review))->toBeTrue();
});

it('denies a customer from updating someone else’s review', function () use ($policy) {
    $customer = new User(['role' => 'customer']);
    $customer->id = 42;

    $otherReview = new Review(['user_id' => 99]);
    expect($policy->update($customer, $otherReview))->toBeFalse();
});

it('allows a librarian to update any review', function () use ($policy) {
    $librarian = new User(['role' => 'librarian']);
    $librarian->id = 5;

    $review = new Review(['user_id' => 5]);
    expect($policy->update($librarian, $review))->toBeTrue();
});

it('allows a customer to delete their own review', function () use ($policy) {
    $customer = new User(['role' => 'customer']);
    $customer->id = 7;

    $review = new Review(['user_id' => 7]);
    expect($policy->delete($customer, $review))->toBeTrue();
});

it('denies a customer from deleting someone else’s review', function () use ($policy) {
    $customer = new User(['role' => 'customer']);
    $customer->id = 7;

    $otherReview = new Review(['user_id' => 8]);
    expect($policy->delete($customer, $otherReview))->toBeFalse();
});
