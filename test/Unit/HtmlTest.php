<?php declare(strict_types=1);

namespace CodeCollabTest\Unit\Template;

use CodeCollab\Template\Html;

class HtmlTest extends \PHPUnit_Framework_TestCase
{
    protected $template;

    public function setUp()
    {
        $this->template = new Html(TEST_DATA_DIR . '/base.phtml');
    }

    /**
     * @covers CodeCollab\Template\Html::__construct
     */
    public function testImplementsCorrectInterface()
    {
        $this->assertInstanceOf('CodeCollab\Template\Renderer', $this->template);
    }

    /**
     * @covers CodeCollab\Template\Html::__construct
     * @covers CodeCollab\Template\Html::render
     */
    public function testRenderWithoutVariables()
    {
        $this->assertSame('withoutvariables', $this->template->render(TEST_DATA_DIR . '/without-variables.phtml'));
    }

    /**
     * @covers CodeCollab\Template\Html::__construct
     * @covers CodeCollab\Template\Html::__get
     * @covers CodeCollab\Template\Html::render
     */
    public function testRenderWithVariables()
    {
        $this->assertSame('variables12', $this->template->render(TEST_DATA_DIR . '/with-variables.phtml', [
            'first'  => 1,
            'second' => 2,
        ]));
    }

    /**
     * @covers CodeCollab\Template\Html::__construct
     * @covers CodeCollab\Template\Html::render
     * @covers CodeCollab\Template\Html::renderPage
     */
    public function testRenderPageWithoutVariables()
    {
        $this->assertSame('BASESTARTwithoutvariablesBASEEND', $this->template->renderPage(TEST_DATA_DIR . '/without-variables.phtml'));
    }

    /**
     * @covers CodeCollab\Template\Html::__construct
     * @covers CodeCollab\Template\Html::__get
     * @covers CodeCollab\Template\Html::render
     * @covers CodeCollab\Template\Html::renderPage
     */
    public function testRenderPageWithVariables()
    {
        $this->assertSame('BASESTARTvariables12BASEEND', $this->template->renderPage(TEST_DATA_DIR . '/with-variables.phtml', [
            'first'  => 1,
            'second' => 2,
        ]));
    }

    /**
     * @covers CodeCollab\Template\Html::__construct
     * @covers CodeCollab\Template\Html::__get
     * @covers CodeCollab\Template\Html::render
     * @covers CodeCollab\Template\Html::renderPage
     */
    public function testRenderPageWithVariablesThrowsOnFirstUndefinedVariable()
    {
        $this->setExpectedException('CodeCollab\Template\UndefinedVariableException');

        $this->template->renderPage(TEST_DATA_DIR . '/with-variables.phtml', [
            'first'  => 1,
        ]);
    }

    /**
     * @covers CodeCollab\Template\Html::__construct
     * @covers CodeCollab\Template\Html::__get
     * @covers CodeCollab\Template\Html::render
     * @covers CodeCollab\Template\Html::renderPage
     */
    public function testRenderPageWithVariablesThrowsOnLaterUndefinedVariable()
    {
        $this->setExpectedException('CodeCollab\Template\UndefinedVariableException');

        $this->template->renderPage(TEST_DATA_DIR . '/with-variables.phtml', [
            'second' => 2,
        ]);
    }

    /**
     * @covers CodeCollab\Template\Html::__construct
     * @covers CodeCollab\Template\Html::render
     * @covers CodeCollab\Template\Html::escape
     */
    public function testEscape()
    {
        $this->assertSame('&quot;', $this->template->render(TEST_DATA_DIR . '/escape.phtml'));
    }

    /**
     * @covers CodeCollab\Template\Html::__construct
     * @covers CodeCollab\Template\Html::render
     * @covers CodeCollab\Template\Html::__isset
     */
    public function testIssetNotSet()
    {
        $this->assertSame('0', $this->template->render(TEST_DATA_DIR . '/isset.phtml'));
    }

    /**
     * @covers CodeCollab\Template\Html::__construct
     * @covers CodeCollab\Template\Html::render
     * @covers CodeCollab\Template\Html::__isset
     */
    public function testIssetSet()
    {
        $this->assertSame('1', $this->template->render(TEST_DATA_DIR . '/isset.phtml', [
            'foo' => 'bar',
        ]));
    }
}
