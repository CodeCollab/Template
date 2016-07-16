<?php declare(strict_types=1);
/**
 * HTML page template renderer
 *
 * PHP version 7.0
 *
 * @category   CodeCollab
 * @package    Template
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    See the LICENSE file
 * @version    1.0.0
 */
namespace CodeCollab\Template;

/**
 * HTML page template renderer
 *
 * @category   CodeCollab
 * @package    Template
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Html implements Renderer
{
    /**
     * @var array List of template variables
     */
    protected $thisShouldMakeItUniqueCodeCollabTemplateHtmlVariables = [];

    /**
     * @var string The base (skeleton) page template
     */
    protected $thisShouldMakeItUniqueCodeCollabTemplateHtmlBasePage;

    /**
     * Creates instance
     *
     * @param string $basePage The base (skeleton) page template
     */
    public function __construct(string $basePage)
    {
        $this->thisShouldMakeItUniqueCodeCollabTemplateHtmlBasePage = $basePage;
    }

    /**
     * Renders a template
     *
     * @param string $template The template to render
     * @param array  $data     The template variables
     *
     * @return string The rendered template
     */
    public function render(string $template, array $data = []): string
    {
        // we store the current state of the template variables
        // so that we have isolated cases on multiple calls to render()
        $backupVariables = $this->thisShouldMakeItUniqueCodeCollabTemplateHtmlVariables;

        if (!empty($data)) {
            $this->thisShouldMakeItUniqueCodeCollabTemplateHtmlVariables = $data;
        }

        try {
            ob_start();

            /** @noinspection PhpIncludeInspection */
            require $template;
        } finally {
            $output = ob_get_clean();
        }

        $this->thisShouldMakeItUniqueCodeCollabTemplateHtmlVariables = $backupVariables;

        return $output;
    }

    /**
     * Renders a page
     *
     * @param string $template The template to render
     * @param array  $data     The template variables
     *
     * @return string The rendered page
     */
    public function renderPage(string $template, array $data = []): string
    {
        $this->thisShouldMakeItUniqueCodeCollabTemplateHtmlVariables = $data;

        /** @noinspection PhpUnusedLocalVariableInspection */
        $content = $this->render($template, $data);

        try {
            ob_start();

            /** @noinspection PhpIncludeInspection */
            require $this->thisShouldMakeItUniqueCodeCollabTemplateHtmlBasePage;
        } finally {
            $output = ob_get_clean();
        }

        return $output;
    }

    /**
     * Escapes the data used in templates
     *
     * @param string $data The data to escape
     *
     * @return string The escaped data
     */
    protected function escape(string $data): string
    {
        return htmlspecialchars($data, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    /**
     * Magic getter
     *
     * @param mixed $key The key of the variable
     *
     * @return mixed The value of the variable
     *
     * @throws \CodeCollab\Template\UndefinedVariableException
     */
    public function __get($key)
    {
        if (!array_key_exists($key, $this->thisShouldMakeItUniqueCodeCollabTemplateHtmlVariables)) {
            throw new UndefinedVariableException('Undefined template variable (`' . $key . '`).');
        }

        return $this->thisShouldMakeItUniqueCodeCollabTemplateHtmlVariables[$key];
    }

    /**
     * Magic isset
     *
     * @param mixed $key The key of the variable
     *
     * @return bool True when the variable is set
     */
    public function __isset($key): bool
    {
        return isset($this->thisShouldMakeItUniqueCodeCollabTemplateHtmlVariables[$key]);
    }
}
