<?php
/**
 * Created by PhpStorm.
 * User: Jean-baptiste
 * Date: 01/06/2019
 * Time: 19:44
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="integer", options={"default":"0"})
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $idCreator;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    public function __construct()
    {
        $this->created_at = new \DateTime();
    }

    function getId()
    {
        return $this->id;
    }

    function getName()
    {
        return $this->name;
    }

    function getDescription()
    {
        return $this->description;
    }

    function getPrice()
    {
        return $this->price;
    }

    function getEtat()
    {
        return $this->etat;
    }

    function getIdCreator()
    {
        return $this->idCreator;
    }

    function getImage()
    {
        return $this->image;
    }

    function getCategory()
    {
        return $this->category;
    }

    function setCategory(\App\Entity\Category $category)
    {
        $this->category = $category;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setName($name)
    {
        $this->name = $name;
    }


    function setDescription($description)
    {
        $this->description = $description;
    }

    function setPrice($price)
    {
        $this->price = $price;
    }

    function setEtat($etat)
    {
        $this->etat = $etat;
    }

    function setIdCreator(\App\Entity\User $idCreator)
    {
        $this->idCreator = $idCreator;
    }

    function setImage($image)
    {
        $this->image = $image;
    }

}