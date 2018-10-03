<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Document;

use AppBundle\Entity\Taxon;
use ONGR\ElasticsearchBundle\Annotation as ElasticSearch;
use ONGR\ElasticsearchBundle\Collection\Collection;

/**
 * @ElasticSearch\Nested()
 */
class TaxonDocument
{
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


    /**
     * @var string
     *
     * @ElasticSearch\Property(type="keyword")
     */
    protected $name;
    
    /**
     * @var int
     *
     * @ElasticSearch\Property(type="integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @ElasticSearch\Property(type="keyword")
     */
    protected $code;

    /**
     * @var string
     *
     * @ElasticSearch\Property(type="keyword")
     */
    protected $slug;

    /**
     * @var int
     *
     * @ElasticSearch\Property(type="integer")
     */
    protected $position = 0;

    /**
     * @var ImageDocument[]|Collection
     *
     * @ElasticSearch\Embedded(class="Sylius\ElasticSearchPlugin\Document\ImageDocument", multiple=true)
     */
    protected $images;

    /**
     * @var string
     *
     * @ElasticSearch\Property(type="text")
     */
    protected $description;

    public function __construct()
    {
        $this->images = new Collection();
        $this->childrens = new Collection();
    }


    public function addChildren(Taxon $taxon)
    {
        $this->childrens->add($taxon);
    }

    public function removeChildren(Taxon $taxon)
    {
        $this->childrens->removeElement($taxon);
    }

    public function getChildrens()
    {
        return $this->childrens;
    }

    public function setParent(?Taxon $taxon)
    {
        $this->parent = $taxon;
    }

    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    /**
     * @return Collection
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    /**
     * @param Collection $images
     */
    public function setImages($images): void
    {
        $this->images = $images;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
