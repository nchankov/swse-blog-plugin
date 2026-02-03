<?php 
/**
 * Trait for replacing some wildcards on the markdown. Such as {{year}} which should default to today's year
 */
trait Replace {
    public function placeholders()
    {
        return [
            '{{year}}' => date('Y'),
            '{{time}}' => date('H:i'),
        ];
    }
    public function replacePlaceholders($content, $placeholders = [])
    {
        if (empty($placeholders)) {
            $placeholders = $this->placeholders();
        }
        foreach ($placeholders as $key => $value) {
            $content = str_replace("$key", $value, $content);
        }
        return $content;
    }
}