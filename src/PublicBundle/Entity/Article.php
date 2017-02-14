<?php

namespace PublicBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="PublicBundle\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     * @NotBlank(message="Veuillez donner un nom à votre article")
     */
    private $name;

    /**
     * @var string
     * @NotBlank(message="L'article doit avoir un corps")
     * @ORM\Column(name="content", type="string", length=2000)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
    * Many Articles have One User.
    * @ORM\ManyToOne(targetEntity="User", inversedBy="articles")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;

    /**
    * One Article has Many Comments.
    * @ORM\OneToMany(targetEntity="Comment", mappedBy="article")
    */
    private $comments;

    /**
    * Many Articles have One Category.
    * @ORM\ManyToOne(targetEntity="Category", inversedBy="articles")
    * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
    */
    private $category;

    /**
    * Many Articles have Many Tags.
    * @ORM\ManyToMany(targetEntity="Tag", inversedBy="articles")
    * @ORM\JoinTable(name="articles_tag",
    *      joinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
    *      )
    * @NotBlank(message="Veuillez choisir au moins un tag")
    */
    private $tags;


    public function __construct() {
      $this->features = new ArrayCollection();
      $this->tags = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Article
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set content
     *
     * @param string $content
     *
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Article
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set user
     *
     * @param \PublicBundle\Entity\User $user
     *
     * @return Article
     */
    public function setUser(\PublicBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \PublicBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add comment
     *
     * @param \PublicBundle\Entity\Comment $comment
     *
     * @return Article
     */
    public function addComment(\PublicBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \PublicBundle\Entity\Comment $comment
     */
    public function removeComment(\PublicBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set category
     *
     * @param \PublicBundle\Entity\Category $category
     *
     * @return Article
     */
    public function setCategory(\PublicBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \PublicBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add tag
     *
     * @param \PublicBundle\Entity\Tag $tag
     *
     * @return Article
     */
    public function addTag(\PublicBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \PublicBundle\Entity\Tag $tag
     */
    public function removeTag(\PublicBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }
}
