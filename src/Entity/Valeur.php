<?php

namespace App\Entity;

use App\Repository\ValeurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;
use App\EventListener\PropertyValeurListener;

/**
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"valeur:read", "enable_max_depth"=true}},
 *     "denormalization_context"={"groups"={"valeur:write"}}
 * })
 * @ORM\Entity(repositoryClass=ValeurRepository::class)
 * @ORM\EntityListeners({"App\EventListener\PropertyValeurListener"})
 */
class Valeur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"property:read", "property:write", "valeur:write"})
     * @ORM\ManyToOne(targetEntity=Propriete::class, inversedBy="valeurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $propriete;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $savedValue;

    /**
     * @Groups({"valeur:write"})
     * @ORM\ManyToOne(targetEntity=Property::class, inversedBy="valeurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bien;

    /**
     * @Groups({"valeur:write", "valeur:read", "property:write", "property:read", "valeur:read"})
     */
    private $value;

    public function __construct()
    {
        $this->savedValue="";
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSavedValue(): ?string
    {
        return $this->savedValue;
    }

    public function setSavedValue($value): self
    {
        if ($this->propriete->getType() === "booleen"){
            $this->savedValue = var_export($value, true);
        }

        if ($this->propriete->getType() === "integer"){
            $this->savedValue = (string)$value;
        }
        
        if ($this->propriete->getType() === "string"){
            $this->savedValue = (string)$value;
        }
        return $this;
    }

    public function getPropriete(): ?Propriete
    {
        return $this->propriete;
    }

    public function setPropriete(?Propriete $propriete): self
    {
        $this->propriete = $propriete;

        return $this;
    }

    public function getBien(): ?Property
    {
        return $this->bien;
    }

    public function setBien(?Property $bien): self
    {
        $this->bien = $bien;

        return $this;
    }

    /*
    */
    public function getValue(){
        if ($this->propriete->getType() === "booleen"){
            $this->value = (bool)$this->savedValue;
        }
        if ($this->propriete->getType() === "string"){
            $this->value = (string)$this->savedValue;

        }
        if ($this->propriete->getType() === "integer"){
            $this->value = (int)$this->savedValue;
        }
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */ 
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
