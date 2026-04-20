import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'template-setting',
    templateUrl: 'template-setting.component.html'
})

export class TemplateSettingComponent implements OnInit {
    constructor() { }

    ngOnInit() {
        if (typeof PR !== 'undefined') {
            setTimeout(() => PR.prettyPrint(), 10);
        }
    }

    appConfigSyntax: string = `import { AppConfig } from import { AppConfig } from '@app/shared/types/app-config.interface';
import { defaultLanguge } from './i18n.config'

export const AppConfiguration : AppConfig = {
    layoutType: 'vertical',
    sideNavCollapse: false,
    lang: defaultLanguge,
    navMenuColor: 'light',
    headerNavColor: '#ffffff'
}

// Change your API endpoint here
export const API_ENDPOINT = '/api'`   

    themeConfigSyntax: string = `@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');

$white:    #fff;
$gray-100: #f3f7f9;
$gray-200: #ebf3f8;
$gray-300: #dce6ed;
$gray-400: #ccdfea;
$gray-500: #a7c1d2;
$gray-600: #7d9eb5;
$gray-700: #486f88;
$gray-800: #343a40;
$gray-900: #00174c;
$black:    #000;

$blue:     #11a1fd;
$indigo:   #5a75f9;
$purple:   #6f42c1;
$pink:     #e83e8c;
$red:      #f46363;
$orange:   #ff9842;
$yellow:   #FFC833;
$green:    #00c569;
$teal:     #2ED477;
$cyan:     #5dcebc;

$colors: (
    "blue":       $blue,
    "indigo":     $indigo,
    "purple":     $purple,
    "pink":       $pink,
    "red":        $red,
    "orange":     $orange,
    "yellow":     $yellow,
    "green":      $green,
    "teal":       $teal,
    "cyan":       $cyan,
    "white":      $white,
    "gray":       $gray-600,
    "gray-dark":  $gray-800
);

$primary:       $blue;
$secondary:     #e4eef5;
$success:       $green;
$info:          $indigo;
$warning:       $orange;
$danger:        $red;
$light:         $gray-100;
$dark:          $gray-800;

$theme-colors: (
    "primary":    $primary,
    "secondary":  $secondary,
    "success":    $success,
    "info":       $info,
    "warning":    $warning,
    "danger":     $danger,
    "light":      $light,
    "dark":       $dark
);

$min-contrast-ratio: 1.5;

$font-family-sans-serif:     'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";

$font-size-root:              null;
$font-size-base:              0.875rem; // Assumes the browser default, typically 16px
$font-size-sm:                $font-size-base * .875;
$font-size-lg:                $font-size-base * 1.25;

$body-bg:                     $gray-100;
$body-color:                  $gray-700;`

}