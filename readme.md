# Symfony Pagination Bundle
Symfony Pagination Bundle

## Create package config file and update .env
```config/packages/giacomoto_pagination.yaml```<br>
```yaml
giacomoto_pagination:
    default_size: '%env(int:GIACOMOTO_PAGINATION_DEFAULT_SIZE)%'
    allowed_sizes: '%env(resolve:GIACOMOTO_PAGINATION_ALLOWED_SIZES)%'
```
```.env```
```shell
###> giacomoto/pagination-bundle ###
GIACOMOTO_PAGINATION_DEFAULT_SIZE=10
GIACOMOTO_PAGINATION_ALLOWED_SIZES=5,10,25,50
###< giacomoto/pagination-bundle ###
```

## Usage
Entity Repository must implements ```IRepositoryHasPagination``` and use the ```TRepositoryHasPaginationTrait```.

UserPagination ex: ```Repository/UserRepository.php```<br>
```php
<?php

namespace App\Repository;

use App\Entity\User;
use Giacomoto\Bundle\GiacomotoPaginationBundle\Class\PaginatedData;
use Giacomoto\Bundle\GiacomotoPaginationBundle\Class\Pagination;
use Giacomoto\Bundle\GiacomotoPaginationBundle\Interface\IRepositoryHasPagination;
use Giacomoto\Bundle\GiacomotoPaginationBundle\Trait\TRepositoryHasPagination;
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
    public function findAllPaginatedCustom(User $user, Pagination $pagination): PaginatedData
    {
        $queryBuilder1 = $this->createQueryBuilder('u')
            ->where('...');

        $queryBuilder2 = $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->where('...');

        return new PaginatedData(
            $this->paginated($pagination, $queryBuilder1),
            $this->paginatedTotal($queryBuilder2)
        );
    }
}
```
``PaginatedData`` will hold your result
```php
class PaginatedData {
    public function __construct(
        private readonly array $data,
        private readonly int $total,
    )
    {
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }
}
```
In your controller:
```php
use Giacomoto\Bundle\GiacomotoPaginationBundle\Class\Pagination;
use Giacomoto\Bundle\GiacomotoPaginationBundle\Service\PaginationService;

class UsersController extends AbstractController
{
    public function getAll(
        Request           $request,
        userRepository    $userRepository
        PaginationService $paginationService,
    ): JsonResponse
    {
        // PaginationService will create for you the Pagination class form the http Request
        // Params are passed in the query url and are "page" and "size", both optional
        $pagination = $paginationService->createFromRequest($request);

        // Alternatively you can create the Pagination class manually
        // $pagination = new Pagination(1 /*page*/, 5 /*size*/);
        
        // Get PaginatedData
        $paginated = $userRepository->findAllPaginated($pagination); 
    
        // ...
    }
}
```
