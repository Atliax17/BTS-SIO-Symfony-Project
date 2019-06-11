<?php
/**
 * Created by PhpStorm.
 * User: Jean-baptiste
 * Date: 02/06/2019
 * Time: 14:48
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class ArticleSearch
{
    /**
     * @var int|null
     */
    private $prixMin;

    /**
     * @var int|null
     */
    private $prixMax;

    /**
     * @return int|null
     */
    public function getPrixMin(): ?int
    {
        return $this->prixMin;
    }

    /**
     * @param int|null $prixMin
     */
    public function setPrixMin(int $prixMin): void
    {
        $this->prixMin = $prixMin;
    }

    /**
     * @return int|null
     */
    public function getPrixMax(): ?int
    {
        return $this->prixMax;
    }

    /**
     * @param int|null $prixMax
     */
    public function setPrixMax(int $prixMax): void
    {
        $this->prixMax = $prixMax;
    }

}