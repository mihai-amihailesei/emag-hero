<?php


namespace Emag\Fighter\Service;


use Emag\Battle\Model\Contestant;
use Emag\Battle\Service\ContestantFactory;
use Emag\Fighter\Exception\NotFoundException;
use Emag\Fighter\Exception\MissingPropertyException;
use Emag\Fighter\Exception\NotImplementedException;
use Symfony\Component\Yaml\Yaml;


class FighterFactory implements ContestantFactory
{
    private array $fightersConfig;
    private SkillsFactory $skillsFactory;

    public function __construct(SkillsFactory $skillsFactory)
    {
        $this->skillsFactory = $skillsFactory;
        $this->fightersConfig = Yaml::parseFile(ROOT_DIR.'/config/fighters.yml');
    }

    public function buildContestant(string $name): Contestant
    {
        $fighterConfig = null;
        foreach ($this->fightersConfig as $fighter) {
            if ($name == $fighter['name']) {
                $fighterConfig = $fighter;
                break;
            }
        }

        if (!$fighterConfig) {
            throw new NotFoundException();
        }

        $fighterClass = 'Emag\\Fighter\\Model\\'.$fighterConfig['type'];
        if (!class_exists($fighterClass)) {
            throw new NotImplementedException();
        }

        $fighterProperties = [
            'name' => $fighterConfig['name'],
            'health' => mt_rand(...$fighterConfig['health_range']),
            'strength' => mt_rand(...$fighterConfig['strength_range']),
            'defense' => mt_rand(...$fighterConfig['defense_range']),
            'speed' => mt_rand(...$fighterConfig['speed_range']),
            'luck' => mt_rand(...$fighterConfig['luck_range']),
        ];
        if (isset($fighterConfig['attack_skill'], $fighterConfig['defense_skill'])) {
            $fighterProperties['attackSkill'] = $this->skillsFactory->getSkill($fighterConfig['attack_skill']);
            $fighterProperties['defenseSkill'] = $this->skillsFactory->getSkill($fighterConfig['defense_skill']);
        }

        try {
            /** @var \Emag\Fighter\Model\Fighter */
            return new $fighterClass(...$fighterProperties);
        } catch (\Exception $e) {
            throw new MissingPropertyException();
        }
    }
}
