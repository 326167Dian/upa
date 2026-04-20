import { Component, OnInit } from '@angular/core';
declare const PR: any;

@Component({
    selector: 'language',
    templateUrl: 'language.component.html'
})

export class LanguageComponent implements OnInit {

    defaultLanguageSyntax = `export const supportedLanguages = {
    en_US: 'English',
    fr_FR: 'French'
}

export const defaultLanguge = localStorage.getItem('lang') ||  Object.keys(supportedLanguages)[0]
`

    newLanguageSyntax = `export const ja_JP = {
    'YOUR_TRANSLATE_KEY': 'あなたの翻訳キー',
};
`
    importTranslationSyntax = `import { ja_JP } from './i18n/ja/index'
    
const storageKey = 'lang'

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html'
})
export class AppComponent implements OnInit, OnDestroy {
    constructor(private translateService: TranslateService) {
        translateService.setTranslation('en_US', en_US);
        translateService.setTranslation('ja_JP', ja_JP);
    }
}
    `
    translationServiceSyntax = `this.translateService.use(yourCurrentLang);`

    usageInHtmlSyntax = `<div>{{YOUR_TRANSLATE_KEY | translate}}</div>`


    constructor() { }

    ngOnInit() {
        if (typeof PR !== 'undefined') {
            setTimeout(() => PR.prettyPrint(), 10);
        }
    }
}