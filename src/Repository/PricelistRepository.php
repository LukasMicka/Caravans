<?php

namespace App\Repository;

use App\Entity\Pricelist;
use App\Entity\Caravan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Pricelist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pricelist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pricelist[]    findAll()
 * @method Pricelist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PricelistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pricelist::class);
    }

    public function findPriceVatForPeriod(\DateTime $dateFrom, \DateTime $dateTill, Caravan $caravan): array
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('SUM(
                        CASE 
                            WHEN p.validFrom >= :dateFromChosen AND p.validTill >= :dateTillChosen THEN DATE_DIFF(:dateTillChosen, p.validFrom)
                            WHEN p.validFrom <= :dateFromChosen AND p.validTill >= :dateTillChosen THEN DATE_DIFF(:dateTillChosen, :dateFromChosen)
                            WHEN p.validFrom <= :dateFromChosen AND p.validTill <= :dateTillChosen THEN DATE_DIFF(p.validTill, :dateFromChosen)
                            WHEN p.validFrom >= :dateFromChosen AND p.validTill <= :dateTillChosen THEN DATE_DIFF(p.validTill, p.validFrom)
                            ELSE 0
                        END
                    ) * p.priceVat AS totalPriceVat', 'p.currency AS currency');
        $qb->andWhere('p.caravan = :caravan')
           ->andWhere('p.validFrom < :dateTillChosen AND p.validTill > :dateFromChosen')
           ->groupBy('p.id');
        $q = $qb->getQuery();
        $resultArray = $q->execute([
            'caravan' => $caravan,
            'dateFromChosen' => $dateFrom->format('Y-m-d'),
            'dateTillChosen' => $dateTill->format('Y-m-d'),
        ]);
        
        $totalPrice = [];
        if(count($resultArray) > 0) {
            $totalPrice['priceVat'] = array_sum(array_column($resultArray, 'totalPriceVat'));
            $totalPrice['currency'] = $resultArray[0]['currency'];
        }

        return $totalPrice;
    }
}
