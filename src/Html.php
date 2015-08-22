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
    private $variables = [];

    /**
     * @var string The base (skeleton) page template
     */
    private $basePage;

    /**
     * Creates instance
     *
     * @param string $basePage The base (skeleton) page template
     */
    public function __construct(string $basePage)
    {
        $this->basePage = $basePage;
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
        if (!empty($data)) {
            $this->variables = $data;
        }

        ob_start();

        require $template;

        return ob_get_clean();
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
        $content = $this->render($template, $data);

        ob_start();

        require $this->basePage;

        return ob_get_clean();
    }

    /**
     * Escapes the data used in templates
     *
     * @param string $data The data to escape
     *
     * @return string The escaped data
     */
    private function escape(string $data): string
    {
        return htmlspecialchars($data, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    /**
     * Magic getter
     *
     * http://3.bp.blogspot.com/-QWWMt9EIYGY/UYh2TDoTjcI/AAAAAAAACBc/OjfEmjyi2EU/s1600/magic+meme.gif
     *
     * @param mixed $key The key of the variable
     *
     * @return mixed The value of the variable
     *
     * @throws \CodeCollab\Template\UndefinedVariableException
     */
    public function __get($key)
    {
        if (!array_key_exists($key, $this->variables)) {
            throw new UndefinedVariableException('Undefined template variable (`' . $key . '`).');
        }

        return $this->variables[$key];
    }

    /**
     * Magic isset
     *
     * http://www.troll.me/images/ancient-aliens-guy/im-not-saying-its-magic-but-magic-thumb.jpg
     *
     * @param mixed $key The key of the variable
     *
     * @return bool True when the variable is set
     */
    public function __isset($key): bool
    {
        return isset($this->variables[$key]);
    }
}
