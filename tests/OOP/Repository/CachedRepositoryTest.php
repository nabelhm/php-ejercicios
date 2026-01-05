<?php
declare(strict_types=1);

namespace Tests\OOP\Repository;

use Ejercicios\OOP\Repository\CachedRepository;
use Ejercicios\OOP\Repository\RepositoryInterface;
use PHPUnit\Framework\TestCase;
use Tests\OOP\Repository\Fixtures\User;

class CachedRepositoryTest extends TestCase
{
    public function testFindUsesCache(): void
    {
        $baseRepo = $this->createMock(RepositoryInterface::class);
        
        $user = new User('Alice');
        $user->id = 'US_1';
        
        $baseRepo->expects($this->once())
            ->method('find')
            ->with('US_1')
            ->willReturn($user);
        
        $cached = new CachedRepository($baseRepo, ttl: 60);
        
        $found1 = $cached->find('US_1');
        $found2 = $cached->find('US_1');
        
        $this->assertSame($user, $found1);
        $this->assertSame($user, $found2);
    }
    
    public function testFindReturnsNullWhenNotFound(): void
    {
        $baseRepo = $this->createMock(RepositoryInterface::class);
        
        $baseRepo->expects($this->once())
            ->method('find')
            ->with('NONEXISTENT')
            ->willReturn(null);
        
        $cached = new CachedRepository($baseRepo, ttl: 60);
        
        $found = $cached->find('NONEXISTENT');
        
        $this->assertNull($found);
    }
    
    public function testSaveUpdatesCache(): void
    {
        $baseRepo = $this->createMock(RepositoryInterface::class);
        
        $user = new User('Alice');
        $user->id = 'US_1';
        
        $baseRepo->expects($this->once())
            ->method('find')
            ->with('US_1')
            ->willReturn($user);
        
        $baseRepo->expects($this->once())
            ->method('save')
            ->with($user);
        
        $cached = new CachedRepository($baseRepo, ttl: 60);
        
        $cached->find('US_1');
        $cached->save($user);
        $cached->find('US_1'); 
    }
    
    public function testDeleteInvalidatesCache(): void
    {
        $baseRepo = $this->createMock(RepositoryInterface::class);
        
        $user = new User('Alice');
        $user->id = 'US_1';
        
        $baseRepo->expects($this->once())
            ->method('find')
            ->with('US_1')
            ->willReturn($user);
        
        $baseRepo->expects($this->once())
            ->method('delete')
            ->with('US_1');
        
        $cached = new CachedRepository($baseRepo, ttl: 60);
        
        $cached->find('US_1');
        $cached->delete('US_1');
    }
    
    public function testCacheExpires(): void
    {
        $baseRepo = $this->createMock(RepositoryInterface::class);
        
        $user = new User('Alice');
        $user->id = 'US_1';
        
        $baseRepo->expects($this->exactly(2))
            ->method('find')
            ->with('US_1')
            ->willReturn($user);
        
        $cached = new CachedRepository($baseRepo, ttl: 1);
        
        $cached->find('US_1');
        sleep(2);
        $cached->find('US_1');
    }
    
    public function testFindAllDoesNotCache(): void
    {
        $baseRepo = $this->createMock(RepositoryInterface::class);
        
        $users = [new User('Alice'), new User('Bob')];
        
        $baseRepo->expects($this->exactly(2))
            ->method('findAll')
            ->willReturn($users);
        
        $cached = new CachedRepository($baseRepo, ttl: 60);
        
        $result1 = $cached->findAll();
        $result2 = $cached->findAll();
        
        $this->assertSame($users, $result1);
        $this->assertSame($users, $result2);
    }
}