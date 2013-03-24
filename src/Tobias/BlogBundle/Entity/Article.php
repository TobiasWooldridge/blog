<?php

namespace Tobias\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
* Article
*
* @ORM\Table()
* @ORM\Entity
* @ORM\HasLifecycleCallbacks()
* @ORM\Entity(repositoryClass="Tobias\BlogBundle\Repository\Article")
*/
class Article
{
    /**
      * @var integer
      *
      * @ORM\Column(name="id", type="integer")
      * @ORM\Id
      * @ORM\GeneratedValue(strategy="AUTO")
      */
    private $id;

    /**
      * @var string
      *
      * @ORM\Column(name="title", type="string", length=255)
      */
    private $title = "";

    /**
      * @var string
      *
      * @Gedmo\Slug(fields={"title"}, style="default", separator="-")
      * @Doctrine\ORM\Mapping\Column(length=255, unique=true)
      */
    private $slug;

    /**
      * @var string
      *
      * @ORM\Column(name="summary", type="text")
      */
    private $summary;

    /**
      * @var string
      *
      * @ORM\Column(name="content", type="text", nullable=true)
      */
    private $content;


    /**
      * @ORM\Column(type="string")
      */
    private $createdSlug;

    /**
      * @Gedmo\Timestampable(on="create")
      * @ORM\Column(type="datetime")
      */
    private $created;

    /**
      * @var \DateTime
      *
      * @Gedmo\Timestampable(on="update")
      * @ORM\Column(name="updated", type="datetime")
      */
    private $updated;

    /**
      * @Gedmo\Blameable(on="create")
      * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
      */
    private $createdBy;

    /**
      * @Gedmo\Blameable(on="update")
      * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
      */
    private $updatedBy;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $hash = "";


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
     * Get disqus id
     *
     * @return string 
     */
    public function getDisqusId()
    {
        return 'article-' . $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
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
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set summary
     *
     * @param string $summary
     * @return Article
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    
        return $this;
    }

    /**
     * Get summary
     *
     * @return string 
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set created slug
     *
     * @ORM\PrePersist
     *
     * @return Article
     */
    public function setCreatedSlug()
    {
      $created = $this->getCreated();
      if (!$created) {
        $created = new \DateTime();
      }

      $this->createdSlug = $created->format('Y');
    }

    /**
     * Get created
     *
     * @return string 
     */
    public function getCreatedSlug()
    {
      return $this->getCreated()->format('Y');
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Article
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Article
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Article
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Set createdBy
     *
     * @param \Application\Sonata\UserBundle\Entity\User $createdBy
     * @return Article
     */
    public function setCreatedBy(\Application\Sonata\UserBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;
    
        return $this;
    }

    /**
     * Set updatedBy
     *
     * @param \Application\Sonata\UserBundle\Entity\User $updatedBy
     * @return Article
     */
    public function setUpdatedBy(\Application\Sonata\UserBundle\Entity\User $updatedBy = null)
    {
        $this->updatedBy = $updatedBy;
    
        return $this;
    }

    /**
     * Update hash
     *
     * @ORM\PrePersist
     */
    public function updateHash()
    {
        $this->hash = md5($this->getTitle() $this->getSummary() . $this->getContent());
    }

    /**
     * Get hash
     */
    public function getHash()
    {
        return $this->hash;
    }
}