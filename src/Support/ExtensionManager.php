<?php

namespace Awcodes\Typist\Support;

use Awcodes\Typist\Tiptap\Extensions as CoreExtensions;
use Awcodes\Typist\Tiptap\Marks as CoreMarks;
use Awcodes\Typist\Tiptap\Nodes as CoreNodes;
use Tiptap\Marks;
use Tiptap\Nodes;

class ExtensionManager
{
    public function __construct(
        protected array $customExtensions = [],
    ) {}

    public static function make(): static
    {
        return app(static::class);
    }

    public function getCustomExtensions(): array
    {
        return [];
    }

    public function getExtensions(): array
    {
        return [
            new Nodes\Document,
            new Nodes\Blockquote,
            new Nodes\BulletList,
            new Nodes\HardBreak,
            new Nodes\Heading,
            new Nodes\HorizontalRule,
            new Nodes\OrderedList,
            new Nodes\Paragraph,
            new Nodes\Text,
            new CoreExtensions\TextAlignExtension([
                'types' => ['heading', 'paragraph'],
            ]),
            new CoreExtensions\ClassExtension,
            new CoreExtensions\IdExtension,
            new CoreExtensions\ColorExtension,
            new CoreNodes\ListItem,
            new CoreNodes\Media,
            new CoreNodes\Details,
            new CoreNodes\DetailsSummary,
            new CoreNodes\DetailsContent,
            new CoreNodes\Grid,
            new CoreNodes\GridColumn,
            new CoreNodes\Lead,
            new CoreNodes\MergeTag,
            new CoreNodes\TypistBlock,
            new Marks\TextStyle,
            new Marks\Underline,
            new Marks\Superscript,
            new Marks\Subscript,
            new Marks\Bold,
            new Marks\Code,
            new Marks\Highlight,
            new Marks\Italic,
            new CoreMarks\Small,
            new Marks\Strike,
            new CoreMarks\Link,
            ...$this->getCustomExtensions(),
        ];
    }
}
