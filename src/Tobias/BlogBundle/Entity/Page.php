<?php

namespace Tobias\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
* Page
*
* @ORM\Table()
* @ORM\Entity
* @ORM\HasLifecycleCallbacks()
*/
class Page
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
      * @ORM\Column(name="content", type="text")
      */
    private $content;


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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Page
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
     * Set content
     *
     * @param string $content
     * @return Page
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
}