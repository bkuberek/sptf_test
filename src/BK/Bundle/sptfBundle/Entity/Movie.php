<?php

namespace BK\Bundle\sptfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BK\Bundle\sptfBundle\Entity\Movie
 *
 * @ORM\Table(name="movie")
 * @ORM\Entity(repositoryClass="BK\Bundle\sptfBundle\Entity\MovieRepository")
 */
class Movie
{

  /**
   * @var integer $id
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var string $url
   *
   * @ORM\Column(name="url", type="string", length=255)
   */
  private $url;

  /**
   * @var string $title
   *
   * @ORM\Column(name="title", type="string", length=255)
   */
  private $title;

  /**
   * @var string $original_title
   *
   * @ORM\Column(name="original_title", type="string", length=255)
   */
  private $original_title;

  /**
   * @var string $description
   *
   * @ORM\Column(name="description", type="string", length=511)
   */
  private $description;

  /**
   * @var smallint $year
   *
   * @ORM\Column(name="year", type="smallint")
   */
  private $year;

  /**
   * @var smallint $length
   *
   * @ORM\Column(name="length", type="smallint")
   */
  private $length;

  /**
   * @var string $director
   *
   * @ORM\Column(name="director", type="string", length=128)
   */
  private $director;

  /**
   * @var string $image_small
   *
   * @ORM\Column(name="image_small", type="string", length=255)
   */
  private $image_small;

  /**
   * @var string $image_large
   *
   * @ORM\Column(name="image_large", type="string", length=255)
   */
  private $image_large;

  /**
   * @var decimal $rating
   *
   * @ORM\Column(name="rating", type="decimal")
   */
  private $rating;

  /**
   * @var integer $votes
   *
   * @ORM\Column(name="votes", type="integer")
   */
  private $votes;

  /**
   * Get id
   *
   * @return integer 
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set url
   *
   * @param string $url
   */
  public function setUrl($url)
  {
    $this->url = $url;
  }

  /**
   * Get url
   *
   * @return string 
   */
  public function getUrl()
  {
    return $this->url;
  }

  /**
   * Set title
   *
   * @param string $title
   */
  public function setTitle($title)
  {
    $this->title = $title;
  }

  /**
   * Get title
   *
   * @return string 
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * Set original_title
   *
   * @param string $originalTitle
   */
  public function setOriginalTitle($originalTitle)
  {
    $this->original_title = $originalTitle;
  }

  /**
   * Get original_title
   *
   * @return string 
   */
  public function getOriginalTitle()
  {
    return $this->original_title;
  }

  /**
   * Set description
   *
   * @param string $description
   */
  public function setDescription($description)
  {
    $this->description = $description;
  }

  /**
   * Get description
   *
   * @return string 
   */
  public function getDescription()
  {
    return $this->description;
  }

  /**
   * Set year
   *
   * @param smallint $year
   */
  public function setYear($year)
  {
    $this->year = $year;
  }

  /**
   * Get year
   *
   * @return smallint 
   */
  public function getYear()
  {
    return $this->year;
  }

  /**
   * Set length
   *
   * @param smallint $length
   */
  public function setLength($length)
  {
    $this->length = $length;
  }

  /**
   * Get length
   *
   * @return smallint 
   */
  public function getLength()
  {
    return $this->length;
  }

  /**
   * Set director
   *
   * @param string $director
   */
  public function setDirector($director)
  {
    $this->director = $director;
  }

  /**
   * Get director
   *
   * @return string 
   */
  public function getDirector()
  {
    return $this->director;
  }

  /**
   * Set image_small
   *
   * @param string $imageSmall
   */
  public function setImageSmall($imageSmall)
  {
    $this->image_small = $imageSmall;
  }

  /**
   * Get image_small
   *
   * @return string 
   */
  public function getImageSmall()
  {
    return $this->image_small;
  }

  /**
   * Set image_large
   *
   * @param string $imageLarge
   */
  public function setImageLarge($imageLarge)
  {
    $this->image_large = $imageLarge;
  }

  /**
   * Get image_large
   *
   * @return string 
   */
  public function getImageLarge()
  {
    return $this->image_large;
  }

  /**
   * Set rating
   *
   * @param decimal $rating
   */
  public function setRating($rating)
  {
    $this->rating = $rating;
  }

  /**
   * Get rating
   *
   * @return decimal 
   */
  public function getRating()
  {
    return $this->rating;
  }

  /**
   * Set votes
   *
   * @param integer $votes
   */
  public function setVotes($votes)
  {
    $this->votes = $votes;
  }

  /**
   * Get votes
   *
   * @return integer 
   */
  public function getVotes()
  {
    return $this->votes;
  }

}