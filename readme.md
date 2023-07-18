# Giacomoto Pagination Bundle
Giacomoto Pagination Bundle

## Update composer.json and register the repositories
```json
{
    ...
    "repositories": [
        {"type": "git", "url":  "https://github.com/giacomoto/pagination-bundle.git"}
    ],
    ...
    "extra": {
        "symfony": {
            ...
            "endpoint": [
                "https://api.github.com/repos/giacomoto/pagination-recipes/contents/index.json",
                "flex://defaults"
            ]
        }
    }
}
```

## Make the repository trusted
```bash
git config --global --add safe.directory /var/www/html/vendor/giacomoto/pagination
```

## Install
```bash
composer require symfony/orm-pack

composer require giacomoto/pagination:dev-main
composer recipes:install giacomoto/pagination --force -v
```

## Usage
Entity Repository must implements IRepositoryHasPagination and use the TRepositoryHasPaginationTrait.

UserPagination ex: ```Repository/UserRepository.php```<br>
```php
<?php

namespace App\Repository;

use App\Entity\User;
use App\Repository\Interface\IRepositoryHasPagination;
use App\Repository\Trait\TRepositoryHasPagination;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository implements IRepositoryHasPagination
{
    use TRepositoryHasPagination;

    // Simple pagination
    public function findAllPaginated(Pagination $pagination): PaginatedData
    {
        $data = $this->paginated($pagination, $this->createQueryBuilder('u')
            ->orderBy('u.createdAt', 'ASC'));

        $total = $this->paginatedTotal();

        return new PaginatedData($data, $total);
    }
    
    // With custom QueryBuilder
    public function findAllUserPaginated(Pagination $pagination): PaginatedData
    {
        $queryBuilder1 = $this->createQueryBuilder('u');
        $queryBuilder1
            ->where('u.roles IN :role')
            ->setParameter('role', '%ROLE_USER%');

        $data = $this->paginated($pagination, $queryBuilder1);

        $queryBuilder2 = $this->createQueryBuilder('u');
        $queryBuilder2
            ->select('count(u.id)')
            ->where('u.roles IN :role')
            ->setParameter('role', '%ROLE_USER%');

        $total = $this->paginatedTotal();

        return new PaginatedData($data, $total);
    }
}
```
