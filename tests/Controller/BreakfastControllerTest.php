<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BreakfastControllerTest extends WebTestCase {

  public function testIndex(): void {
    $client = static::createClient();
    $crawler = $client->request('GET', '/');
    $this->assertResponseIsSuccessful();
    $this->assertSelectorTextContains('h1', 'Breakfasts');
    $this->assertCount(3, $crawler->filter('h2'));
  }

  public function testShow(): void {
    $client = static::createClient();
    $client->request('GET', '/breakfast/omelette_et_pain');
    $this->assertResponseIsSuccessful();
    $this->assertPageTitleContains('Breakfast - Omelette et pain');
    $this->assertSelectorTextContains('h1', 'Omelette et pain');
    $this->assertSelectorTextContains('h2', 'Dishes');
  }

  public function testAddReview(): void {
    $client = static::createClient();
    $client->request('GET', '/breakfast/omelette_et_pain');
    $client->submitForm('Submit', [
      'review_form[email]' => 'test@test.de',
      'review_form[grade]' => '1'
    ]);
    $crawler = $client->followRedirect();
    $this->assertResponseIsSuccessful();
    $this->assertSelectorTextContains('.review', 'test@test.de : Not good');
  }

}
