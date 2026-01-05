<?php
declare(strict_types=1);

namespace Tests\OOP\Repository;

use DateTimeImmutable;
use Ejercicios\OOP\Repository\InMemoryRepository;
use PHPUnit\Framework\TestCase;
use Tests\OOP\Repository\Fixtures\User;

class InMemoryRepositoryTest extends TestCase
{
    public function testSaveAndFindReturnsEntity() : void {
        $repository = new InMemoryRepository();
        $user = new User('Nabe');
        $user->id = 'US_1';
    
        $repository->save($user);
        $this->assertCount(1, $repository->findAll());

        $found= $repository->find('US_1');
        $this->assertEquals($user, $found);
    }

    public function testSaveCreateId() : void {
        $repository = new InMemoryRepository();
        $user = new User('Nabe');
    
        $repository->save($user);
        $this->assertCount(1, $repository->findAll());

        $found= $repository->findAll()[0];
        $this->assertEquals($user->name, $found->name);
        $this->assertIsString($found->id);
    }

    public function testFindRetunrsNull() : void {
        $repository = new InMemoryRepository();
       
        $this->assertCount(0, $repository->findAll());

        $found= $repository->find('US_1');
        $this->assertEquals(null, $found);
    }

    public function testDelete() : void {
         
        $repository = new InMemoryRepository();
        $user = new User('Nabe');
        $user->id = 'US_1';
    
        $repository->save($user);

        $repository->delete('US_1');
        $this->assertCount(0, $repository->findAll());

        $found= $repository->find('US_1');
        $this->assertEquals(null, $found);
    }

    public function testFindAll() : void {
        $repository = new InMemoryRepository();
        $user = new User('Nabe');
        $user->id = 'US_1';
        $repository->save($user);

        $user1 = new User('Damia');
        $user1->id = 'US_2';
        $repository->save($user1);

        $allFound = $repository->findAll();
        $this->assertCount(2, $allFound);
        $this->assertEquals($user, $allFound[0]);
        $this->assertEquals($user1, $allFound[1]);
    }

    public function testTimestampable(): void
    {
        $user = new User('Nabe');
        $user->id = 'US_1';

        $createdAt = $user->createdAt;
        $updatedAt = $user->updatedAt;

        $this->assertInstanceOf(DateTimeImmutable::class, $createdAt);
        $this->assertInstanceOf(DateTimeImmutable::class, $updatedAt);
        
        //Doesn´t change at saving
        $repository = new InMemoryRepository();
        $repository->save($user);

        $found = $repository->find('US_1');
        $this->assertEquals($createdAt, $found->createdAt);
        $this->assertEquals($createdAt, $found->updatedAt);
    }

}