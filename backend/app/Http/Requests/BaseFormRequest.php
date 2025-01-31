<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseFormRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function filtersDate(): array
    {
        return [
            'filters.start_date' => ['required_with:end_date', 'date_format:Y-m-d'],
            'filters.end_date' => ['required_with:start_date', 'date_format:Y-m-d', 'after:start_date'],
        ];
    }

    public function orderBy(): array
    {
        return [
            'order_by_column' => ['nullable', 'string'],
            'order_by_direction' => ['nullable', 'string', 'in:asc,desc'],
        ];
    }

    public function paginate(): array
    {
        return [
            'paginate' => ['nullable', 'string', 'in:true,false,1,0'],
        ];
    }

    public function sanitizeJsonData($fields)
    {
        foreach ($fields as $key => $value) {
            if (is_string($value)) {
                $fields[$key] = $this->removeHtmlTags($value);
                $fields[$key] = $this->removeJavaScriptFunctions($fields[$key]);
            }
        }

        return $fields;
    }

    public function removeHtmlTags($string): string
    {
        return strip_tags($string);
    }

    public function removeJavaScriptFunctions($string): string
    {
        $patterns = [
            '/<script.*?>(.*?)<\/script>/is',                     // Remove tags <script> e seu conteúdo
            '/javascript:/i',                                     // Remove qualquer uso de javascript em URLs
            '/on[a-z]+=[\'"][^\'"]*[\'"]/i',                      // Remove atributos de eventos (ex: onmouseover, onclick, etc)
            '/[a-z]+\([^)]*\)/i',                                 // Remove funções com parênteses (ex: alert(), prompt(), etc)
            '/<.*?javascript:.*?>/i',                             // Remove tags com 'javascript:' em qualquer atributo
            '/style\s*=\s*["\'][^"\']*javascript:[^"\']*["\']/i', // Remove uso de javascript em atributos style
            '/\s*;\s*/',                                          // Remove ponto e vírgula extra
        ];

        $cleanedString = preg_replace($patterns, '', $string);

        return trim($cleanedString);
    }
}
