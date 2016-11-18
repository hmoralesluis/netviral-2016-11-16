<?php

namespace App\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description
 *
 * @ORM\Table(name="description_tb")
 * @ORM\Entity(repositoryClass="App\AdminBundle\Entity\DescriptionRepository")
 */
class Description
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
     * @ORM\Column(name="fast_text", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $fastText;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     * @Assert\NotBlank()
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="descriptions")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     */
    private $product;

    /**
     * @ORM\OneToMany(targetEntity="Language", mappedBy="description")
     */
    private $languages;

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        $this->languages = new ArrayCollection();
    }

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
     * Set fastText
     *
     * @param string $fastText
     * @return Description
     */
    public function setFastText($fastText)
    {
        $this->fastText = $fastText;

        return $this;
    }

    /**
     * Get fastText
     *
     * @return string
     */
    public function getFastText()
    {
        return $this->fastText;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Description
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set product
     *
     * @param \App\AdminBundle\Entity\Product $product
     * @return Description
     */
    public function setProduct(\App\AdminBundle\Entity\Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \App\AdminBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Add language
     *
     * @param Language $language
     * @return Product
     */
    public function addLanguage(Language $language)
    {
        $this->languages[] = $language;

        return $this;
    }

    /**
     * Remove language
     *
     * @param Language $language
     */
    public function removeLanguage(Language $language)
    {
        $this->languages->removeElement($language);
    }

    /**
     * Get languages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLanguages()
    {
        return $this->languages;
    }
}
