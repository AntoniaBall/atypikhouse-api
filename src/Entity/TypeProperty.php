<?php

namespace App\Entity;

use App\Repository\TypePropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource(normalizationContext={"groups"={"typeproperty:read"}},
 *     denormalizationContext={"groups"={"typeproperty:write"}},
 *     collectionOperations={
 *          "get",
 *          "post"={
 *              "security"="is_granted('ROLE_ADMIN')"
 *          }
 * }
 * )
 * @ORM\Entity(repositoryClass=TypePropertyRepository::class)
 */
class TypeProperty
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"typeproperty:read", "typeproperty:write", "property:read"})
     * @ORM\Column(type="string", length=50)
     */
    private $title;
    
    /**
     * @Groups({"typeproperty:read", "typeproperty:write", "property:read"})
     * @Groups({"typeproperty:read", "typeproperty:write"})
     * @ORM\Column(type="string", length=255)
     */
    private $description;
    
    /**
     * @Groups("typeproperty:read",  "typeproperty:write")
     * @ORM\OneToMany(targetEntity=Property::class, mappedBy="typeProperty", orphanRemoval=true)
     */
    private $properties;

    /**
     * @ORM\OneToMany(targetEntity=ProprieteTypeProperty::class, mappedBy="typeProperty")
     */
    private $proprieteTypeProperties;

    /**
     * @Groups({"typeproperty:read", "property:read"})
     * @ORM\OneToMany(targetEntity=Propriete::class, mappedBy="typeProperty")
     */
    private $proprietes;


    public function __construct()
    {
        $this->properties = new ArrayCollection();
        $this->proprieteTypeProperties = new ArrayCollection();
        $this->proprietes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|ProprieteTypeProperty[]
     */
    public function getProprieteTypeProperties(): Collection
    {
        return $this->proprieteTypeProperties;
    }
    
    public function addProprieteTypeProperty(ProprieteTypeProperty $proprieteTypeProperty): self
    {
        if (!$this->proprieteTypeProperties->contains($proprieteTypeProperty)) {
            $this->proprieteTypeProperties[] = $proprieteTypeProperty;
            $proprieteTypeProperty->setTypeProperty($this);
        }

        return $this;
    }

    public function removeProprieteTypeProperty(ProprieteTypeProperty $proprieteTypeProperty): self
    {
        if ($this->proprieteTypeProperties->removeElement($proprieteTypeProperty)) {
            // set the owning side to null (unless already changed)
            if ($proprieteTypeProperty->getTypeProperty() === $this) {
                $proprieteTypeProperty->setTypeProperty(null);
            }
        }

        return $this;
    }
    
    /**
     * @return Collection|ProprieteTypeProperty[]
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Property $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties[] = $property;
            $property->setTypeProperty($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): self
    {
        if ($this->proprieteTypeProperties->removeElement($property)) {
            // set the owning side to null (unless already changed)
            if ($property->getTypeProperty() === $this) {
                $property->setTypeProperty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Propriete[]
     */
    public function getProprietes(): Collection
    {
        return $this->proprietes;
    }

    public function addPropriete(Propriete $propriete): self
    {
        if (!$this->proprietes->contains($propriete)) {
            $this->proprietes[] = $propriete;
            $propriete->setTypeProperty($this);
        }

        return $this;
    }

    public function removePropriete(Propriete $propriete): self
    {
        if ($this->proprietes->removeElement($propriete)) {
            // set the owning side to null (unless already changed)
            if ($propriete->getTypeProperty() === $this) {
                $propriete->setTypeProperty(null);
            }
        }

        return $this;
    }

}
