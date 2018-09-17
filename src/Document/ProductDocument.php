<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Document;

use ONGR\ElasticsearchBundle\Annotation as ElasticSearch;
use ONGR\ElasticsearchBundle\Collection\Collection;

/**
 * @ElasticSearch\Document(type="product")
 */
class ProductDocument
{
    /**
     * @var string
     *
     * @ElasticSearch\Id()
     */
    protected $uuid;

    /**
     * @var mixed
     *
     * @ElasticSearch\Property(type="keyword")
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
     * @ElasticSearch\Property(
     *    type="text",
     *    name="name",
     *    options={
     *        "fielddata"=true,
     *        "analyzer"="standard",
     *        "fields"={
     *            "raw"={"type"="keyword"},
     *            "standard"={"type"="text", "analyzer"="standard"}
     *        }
     *    }
     * )
     */
    protected $name;

     /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }


    /**
     * @var integer
     *
     * @ElasticSearch\Property(type="integer")
     */

    protected $user_id;

    /**
     * @var bool
     *
     * @ElasticSearch\Property(type="boolean")
     */

    protected $review;

    /**
     * @var bool
     *
     * @ElasticSearch\Property(type="boolean")
     */

    protected $in_magazine;
    
    /**
     * @var bool
     *
     * @ElasticSearch\Property(type="boolean")
     */
    protected $enabled;

    /**
     * @var string
     *
     * @ElasticSearch\Property(type="keyword")
     */
    protected $slug;

    /**
     * @var string
     *
     * @ElasticSearch\Property(type="keyword")
     */
    protected $channelCode;

    /**
     * @var string
     *
     * @ElasticSearch\Property(type="keyword")
     */
    protected $localeCode;

    /**
     * @var string
     *
     * @ElasticSearch\Property(type="text")
     */
    protected $description;

    /**
     * @var PriceDocument
     *
     * @ElasticSearch\Embedded(class="Sylius\ElasticSearchPlugin\Document\PriceDocument")
     */
    protected $price;

    /**
     * @var TaxonDocument
     *
     * @ElasticSearch\Embedded(class="Sylius\ElasticSearchPlugin\Document\TaxonDocument")
     */
    protected $mainTaxon;

    /**
     * @var Collection|TaxonDocument[]
     *
     * @ElasticSearch\Embedded(class="Sylius\ElasticSearchPlugin\Document\TaxonDocument", multiple=true)
     */
    protected $taxons;

    /**
     * @var Collection
     *
     * @ElasticSearch\Embedded(class="Sylius\ElasticSearchPlugin\Document\AttributeDocument", multiple=true)
     */
    protected $attributes;

    /**
     * @var Collection
     *
     * @ElasticSearch\Embedded(class="Sylius\ElasticSearchPlugin\Document\ImageDocument", multiple=true)
     */
    protected $images;

    /**
     * @var float
     */
    protected $averageReviewRating;

    /**
     * @var \DateTimeInterface
     *
     * @ElasticSearch\Property(type="date")
     */
    protected $createdAt;

    /**
     * @var Collection
     *
     * @ElasticSearch\Embedded(class="Sylius\ElasticSearchPlugin\Document\VariantDocument", multiple=true)
     */
    protected $variants;


    /**
     * @var \DateTimeInterface
     *
     * @ElasticSearch\Property(type="date")
     */
    protected $synchronisedAt;

    public function __construct()
    {
        $this->attributes = new Collection();
        $this->taxons = new Collection();
        $this->images = new Collection();
        $this->variants = new Collection();
        $this->appliedPromotions = new Collection();
    }




    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isReview(): ?bool
    {
        return $this->review;
    }

    /**
     * @param bool $review
     */
    public function setReview(bool $review): void
    {
        $this->review = $review;
    }

    public function getReview() : ?bool
    {
        return $this->review;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
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
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
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
     * @return string
     */
    public function getChannelCode(): string
    {
        return $this->channelCode;
    }

    /**
     * @param string $channelCode
     */
    public function setChannelCode(string $channelCode): void
    {
        $this->channelCode = $channelCode;
    }

    /**
     * @return string
     */
    public function getLocaleCode(): string
    {
        return $this->localeCode;
    }

    /**
     * @param string $localeCode
     */
    public function setLocaleCode(string $localeCode): void
    {
        $this->localeCode = $localeCode;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return PriceDocument
     */
    public function getPrice(): PriceDocument
    {
        return $this->price;
    }

    /**
     * @param PriceDocument $price
     */
    public function setPrice(PriceDocument $price): void
    {
        $this->price = $price;
    }

    /**
     * @return TaxonDocument
     */
    public function getMainTaxon(): ?TaxonDocument
    {
        return $this->mainTaxon;
    }

    /**
     * @param TaxonDocument $mainTaxon
     */
    public function setMainTaxon(TaxonDocument $mainTaxon): void
    {
        $this->mainTaxon = $mainTaxon;
    }

    /**
     * @return Collection|TaxonDocument[]
     */
    public function getTaxons()
    {
        return $this->taxons;
    }

    /**
     * @param Collection|TaxonDocument[] $taxons
     */
    public function setTaxons($taxons): void
    {
        $this->taxons = $taxons;
    }

    /**
     * @return Collection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param Collection $attributes
     */
    public function setAttributes($attributes): void
    {
        $this->attributes = $attributes;
    }

    /**
     * @return Collection
     */
    public function getImages()
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
     * @return float
     */
    public function getAverageReviewRating(): ?float
    {
        return $this->averageReviewRating;
    }

    /**
     * @param float $averageReviewRating
     */
    public function setAverageReviewRating(float $averageReviewRating): void
    {
        $this->averageReviewRating = $averageReviewRating;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getSynchronisedAt(): \DateTimeInterface
    {
        return $this->synchronisedAt;
    }

    /**
     * @param \DateTimeInterface $synchronisedAt
     */
    public function setSynchronisedAt(\DateTimeInterface $synchronisedAt): void
    {
        $this->synchronisedAt = $synchronisedAt;
    }

    /**
     * @return Collection
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * @param Collection $variants
     */
    public function setVariants($variants): void
    {
        $this->variants = $variants;
    }
    
    public function setInMagazine(?bool $in_magazine) : void
    {
        $this->in_magazine = $in_magazine;
    }

    public function getInMagazine() : ?bool
    {
        return $this->in_magazine;
    }

    /**
     * @var PriceDocument
     *
     * @ElasticSearch\Embedded(class="Sylius\ElasticSearchPlugin\Document\PriceDocument")
     */
    private $originalPrice;

    /**
     * @var Collection
     *
     * @ElasticSearch\Embedded(class="Urbanara\CatalogPromotionPlugin\ElasticSearch\Document\AppliedPromotionDocument", multiple=true)
     */
    private $appliedPromotions;


    /**
     * @return PriceDocument
     */
    public function getOriginalPrice()
    {
        return $this->originalPrice;
    }

    /**
     * @param PriceDocument $originalPrice
     */
    public function setOriginalPrice(PriceDocument $originalPrice)
    {
        $this->originalPrice = $originalPrice;
    }

    /**
     * @return Collection
     */
    public function getAppliedPromotions()
    {
        return $this->appliedPromotions;
    }

    /**
     * @param Collection $appliedPromotions
     */
    public function setAppliedPromotions($appliedPromotions)
    {
        $this->appliedPromotions = $appliedPromotions;
    }
}
