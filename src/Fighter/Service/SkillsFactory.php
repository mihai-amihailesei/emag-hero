<?php


namespace Emag\Fighter\Service;


use Emag\Fighter\Exception\NotFoundException;
use Emag\Fighter\Exception\NotImplementedException;
use Emag\Fighter\Model\Skill;
use Symfony\Component\Yaml\Yaml;

class SkillsFactory
{
    private array $skillsConfig;

    public function __construct()
    {
        $this->skillsConfig = Yaml::parseFile(ROOT_DIR.'/config/skills.yml');
    }

    public function getSkill(string $skillName): Skill
    {
        $skillConfig = null;
        foreach ($this->skillsConfig as $skill) {
            if ($skillName == $skill['name']) {
                $skillConfig = $skill;
                break;
            }
        }

        if (!$skillConfig) {
            throw new NotFoundException();
        }

        if (!method_exists(Skill::class, $skill['action'])) {
            throw new NotImplementedException();
        }

        return new Skill($skill['action'], $skillName, $skill['description'], $skill['activation_rate']);
    }
}
