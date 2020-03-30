<?php 

namespace App\Views;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Symfony\Component\Translation\Translator;

class TranslatorExtension extends AbstractExtension
{
    protected $translator;
    
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('trans', [$this, 'trans']),
            new TwigFunction('trans_choice', [$this, 'transChoice']),
            new TwigFunction('locale', [$this, 'locale'])
        ];
    }

    public function trans($key, $params = [])
    {
        return $this->translator->trans($key, $params);
    }

    public function transChoice($key, $count = 1, $params = [])
    {
        return $this->translator->transChoice($key, $count, $params);
    }

    public function locale()
    {
        return $this->translator->getLocale();
    }
}
