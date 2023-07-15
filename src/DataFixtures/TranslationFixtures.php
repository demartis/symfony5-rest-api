<?php

namespace App\DataFixtures;

use App\Entity\Language;
use App\Entity\Translation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Contracts\Translation\TranslatorInterface;


class TranslationFixtures extends Fixture
{

    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    public function load(ObjectManager $manager): void
    {
        $locales = [];
        // Create and persist languages
        $english = new Language();
        $english->setName('en');
        $manager->persist($english);
        $locales[] = $english;

        $croatian = new Language();
        $croatian->setName('hr');
        $manager->persist($croatian);
        $locales[] = $croatian;

        foreach ($locales as $locale) {
            //category title translations
            $this->createTranslations($locale, 10, 'Meal Category', $manager);
            
            //tag title translations
            $this->createTranslations($locale, 25, 'Meal Tag', $manager);

            //ingredient title translations
            $this->createTranslations($locale, 20, 'Ingredient name', $manager);

            //meal title translations
            $this->createTranslations($locale, 20, 'Meal Name', $manager);

            //meal description translations
            $this->createTranslations($locale, 20, 'Omnis quidem labore culpa id. -', $manager);


        }

    }

    public function createTranslations(Language $language, int $numOfTranslations, string $keyword, ObjectManager $manager): void
    {
        for ($i=1; $i <= $numOfTranslations; $i++) { 
            $this->translator->setLocale($language->getName());
            $translation = new Translation();
            $translation->setKeyword($keyword . ' ' . $i);
            $translation->setValue($this->translator->trans($keyword . ' ' . $i));
            $translation->setLanguage($language);
            $manager->persist($translation);
        }
        $manager->flush();
    }
}
