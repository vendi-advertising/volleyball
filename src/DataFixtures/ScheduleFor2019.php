<?php

namespace App\DataFixtures;

use App\Entity\DayOfWeek;
use App\Entity\Game;
use App\Entity\GameNight;
use App\Entity\GameWeek;
use App\Entity\Team;
use App\Repository\DayOfWeekRepository;
use App\Repository\GameNightRepository;
use App\Repository\GameWeekRepository;
use App\Repository\TeamRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ScheduleFor2019 extends Fixture
{
    private $dayOfWeekRepository;
    private $gameWeekRepository;
    private $gameNightRepository;
    private $teamRepository;

    public function __construct(DayOfWeekRepository $dayOfWeekRepository, GameWeekRepository $gameWeekRepository, GameNightRepository $gameNightRepository, TeamRepository $teamRepository)
    {
        $this->dayOfWeekRepository = $dayOfWeekRepository;
        $this->gameWeekRepository = $gameWeekRepository;
        $this->gameNightRepository = $gameNightRepository;
        $this->teamRepository = $teamRepository;
    }

    public function load(ObjectManager $manager)
    {
        $daysOfWeek = [
                'Monday' => [
                    1 => 'Red Pines',
                    2 => 'Volley Parton',
                    3 => 'Aint Got It',
                    4 => 'Hit Faced',
                    5 => 'Net Results',
                    6 => 'Schoolhouse Rocks',
                ],
                'Tuesday' => [
                    1 => 'Two Bump Chumps',
                    2 => 'Will Work For Sets',
                    3 => 'Get Spiked',
                    4 => 'All About That Ace',
                    5 => 'Sets & Beer',
                    6 => 'Just The Tips',
                ],
                'Wednesday' => [
                    1 => 'Smokey’s Bar & Grill',
                    2 => 'Home Maintenance Experts',
                    3 => 'Learning Curve',
                    4 => 'Never Nudes',
                    5 => 'Super Hitters',
                ],
                'Thursday' => [
                    1 => 'Unprotected Sets',
                    2 => 'That’s What She Set',
                    3 => 'No Dig’ity',
                    4 => 'Hit It & Quit It',
                    5 => 'Sandstorm',
                    6 => 'Harter’s',
                ],
        ];

        $schedule = [
            'Week 1,4/29,5:30pm,Team 1 vs. Team 2,6:30pm,Team 3 vs. Team 4,7:30pm,Team 5 vs. Team 6',
            'Week 2,5/6,5:30pm,Team 4 vs. Team 6,6:30pm,Team 2 vs. Team 5,7:30pm,Team 1 vs. Team 3',
            'Week 3,5/13,5:30pm,Team 3 vs. Team 6,6:30pm,Team 1 vs. Team 5,7:30pm,Team 2 vs. Team 4',
            'Week 4,5/20,5:30pm,Team 1 vs. Team 4,6:30pm,Team 3 vs. Team 5,7:30pm,Team 2 vs. Team 6',
            'Week 5,5/27,5:30pm,Team 1 vs. Team 6,6:30pm,Team 2 vs. Team 3,7:30pm,Team 4 vs. Team 5',
            'Week 6,6/3,5:30pm,Team 2 vs. Team 5,6:30pm,Team 4 vs. Team 6,7:30pm,Team 1 vs. Team 3',
            'Week 7,6/10,5:30pm,Team 5 vs. Team 6,6:30pm,Team 3 vs. Team 4,7:30pm,Team 1 vs. Team 2',
            'Week 8,6/17,5:30pm,Team 2 vs. Team 4,6:30pm,Team 1 vs. Team 5,7:30pm,Team 3 vs. Team 6',
            'Week 9,6/24,5:30pm,Team 1 vs. Team 4,6:30pm,Team 3 vs. Team 5,7:30pm,Team 2 vs. Team 6',
            'Week 10,7/1,5:30pm,Team 1 vs. Team 6,6:30pm,Team 2 vs. Team 3,7:30pm,Team 4 vs. Team 5',
            'Week 12,7/8,5:30pm,Team 1 vs. Team 2,6:30pm,Team 5 vs. Team 6,7:30pm,Team 3 vs. Team 4',
            'Week 13,7/15,5:30pm,Team 4 vs. Team 5,6:30pm,Team 2 vs. Team 3,7:30pm,Team 1 vs. Team 6 ',
            'Week 14,7/22,5:30pm,Team 2 vs. Team 6,6:30pm,Team 1 vs. Team 4,7:30pm,Team 3 vs. Team 5',
            'Week 15,7/29,5:30pm,Team 1 vs. Team 5,6:30pm,Team 2 vs. Team 4,7:30pm,Team 3 vs. Team 6',
            'Week 16,8/5,5:30pm,Team 4 vs. Team 6,6:30pm,Team 2 vs. Team 5,7:30pm,Team 1 vs. Team 3',
        ];

        foreach($daysOfWeek as $dayName => $teamInfo){
            $day = new DayOfWeek();
            $day->setName($dayName);
            $manager->persist($day);
        }

        $manager->flush();

        foreach($daysOfWeek as $dayName => $teamInfo){
            $day = $this->dayOfWeekRepository->findOneBy(['name' => $dayName]);

            foreach($teamInfo as $teamNumber => $teamName){
                $team = new Team();
                $team->setDayOfWeek($day);
                $team->setTeamNumber($teamNumber);
                $team->setName($teamName);
                $manager->persist($team);
            }
        }

        $manager->flush();

        foreach($schedule as $row){
            $parts = explode(',', $row);

            $gameWeekName = $parts[0];
            $gameWeekNameParts = explode(' ', $gameWeekName);

            $gameWeek = new GameWeek();
            $gameWeek->setWeekNumber((int) $gameWeekNameParts[1]);
            $gameWeek->setWeekStartDate(date_create($parts[1]));

            $manager->persist($gameWeek);
        }

        $manager->flush();

        foreach($schedule as $row){
            $parts = explode(',', $row);

            $gameWeekName = $parts[0];
            $gameWeekNameParts = explode(' ', $gameWeekName);

            $gameWeek = $this->gameWeekRepository->findOneBy(['weekNumber' => (int) $gameWeekNameParts[1]]);
            $idx = 0;
            foreach($daysOfWeek as $dayName => $teamInfo){
                $gameNight = new GameNight();
                $gameWeekDate = clone $gameWeek->getWeekStartDate();
                $gameWeekDate->modify("+{$idx} days");
                $gameNight->setGameNightDate($gameWeekDate);
                $gameNight->setGameWeek($gameWeek);
                $manager->persist($gameNight);

                $idx++;
            }
        }

        $manager->flush();



        foreach($schedule as $row){
            $parts = explode(',', $row);

            $gameWeekName = array_shift($parts);
            $gameWeekNameParts = explode(' ', $gameWeekName);

            //Remove the date, done above
            array_shift($parts);

            $gameWeek = $this->gameWeekRepository->findOneBy(['weekNumber' => (int) $gameWeekNameParts[1]]);
            $idx = 0;
            foreach($daysOfWeek as $dayName => $teamInfo){

                $dayOfWeek = $this->dayOfWeekRepository->findOneBy(['name' => $dayName]);

                $local_parts = $parts;

                $gameWeekDate = clone $gameWeek->getWeekStartDate();
                $gameWeekDate->modify("+{$idx} days");

                $gameNight = $this->gameNightRepository->findOneBy(['gameNightDate' => $gameWeekDate, 'gameWeek' => $gameWeek]);

                while(count($local_parts)){
                    $time = array_shift($local_parts);
                    $teams = array_shift($local_parts);

                    $game = new Game();
                    $game->setGameNight($gameNight);
                    $game->setTime($time);

                    $team_parts = explode('vs.', str_replace('Team ', '', $teams));

                    while(count($team_parts)){
                        $teamNumber = (int) array_shift($team_parts);

                        $team = $this->teamRepository->findOneBy([
                            'teamNumber' => $teamNumber,
                            'dayOfWeek' => $dayOfWeek,
                        ]);

                        if($team){
                            $game->addTeam($team);
                        }
                    }

                    $manager->persist($game);

                }
            }
        }

        $manager->flush();


    }
}
