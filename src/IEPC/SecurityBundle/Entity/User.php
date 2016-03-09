<?php namespace IEPC\SecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="iepc_user")
 * @ORM\Entity(repositoryClass="IEPC\SecurityBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    // <editor-fold defaultstate="collapsed" desc="Constants">
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Properties">

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue()
     */
    protected $id;

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Relations">
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Getter and setters">
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Functions">

    public function __construct()
    {
        parent::__construct();
    }

    // </editor-fold>
}
