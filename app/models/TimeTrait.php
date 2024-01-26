<?php

namespace MPuget\blog\models;

use MPuget\blog\utils\Database;

// TimeTrait est une class que l'on pourra appeler dans certaines autre classe
// (c'est une forme d'héritage)
// La plus part de nos modèles vont hériter de cette classe / de ce trait !
trait TimeTrait
{
    // ici on va définir toutes les propriétés & méthodes communes à tous nos modèles !

    protected $id;
    protected $created_at;
    protected $updated_at;

    /**
     * Get the value of id
     * 
     * @return Integer Id du produit
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }  

    /**
     * Get the value of updated_at
     */ 
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}