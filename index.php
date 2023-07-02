<?php

class Bob
{
    public function respondTo(string $phrase): string
    {
        $phrase = trim($phrase, "\n\r \t\u{000b}\u{00a0}\u{2002}}");
        // Silence
        if (empty($phrase)) {
            return 'Fine. Be that way!';
        }
        // Shouting
        if (preg_match('/[A-Z]+/', $phrase) && !preg_match('/[a-z]+/', $phrase)) {
            if (str_ends_with($phrase, '?')) {
                return 'Calm down, I know what I\'m doing!';
            }
            return 'Whoa, chill out!';
        }
        // Question
        if (str_ends_with($phrase, '?')) {
            return 'Sure.';
        }
        return 'Whatever.';
    }
}