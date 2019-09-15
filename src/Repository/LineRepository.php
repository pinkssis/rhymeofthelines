<?php

namespace App\Repository;

use App\Entity\Line;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Line|null find($id, $lockMode = null, $lockVersion = null)
 * @method Line|null findOneBy(array $criteria, array $orderBy = null)
 * @method Line[]    findAll()
 * @method Line[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LineRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Line::class);
    }

    public function add(Line $string)
    {

        $this->_em->persist($string);
        $this->_em->flush();
    }

    public function delete(Line $string)
    {
        $this->_em->remove($string);
        $this->_em->flush();
    }


    public function getlines(string $end)
    {
        $lines = $this->findAll();
        $newLines = array_rand($lines);
        foreach($newLines as $newLine)
        {
            $Linezz = $this->findBy(['end' => $newLine->getEnd]);
            $twolines = array_rand($Linezz);
            return [$newLines, $twolines];
        }

    }
}
