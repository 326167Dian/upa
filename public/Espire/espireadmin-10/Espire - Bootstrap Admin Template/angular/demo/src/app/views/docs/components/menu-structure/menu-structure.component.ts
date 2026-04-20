import { Component, OnInit } from '@angular/core';
declare const PR: any;

@Component({
    selector: 'menu-structure',
    templateUrl: 'menu-structure.component.html'
})

export class MenuStructureComponent implements OnInit {

    navMetaDataSyntax = `interface NavMenu {
    path: string;
    title: string;
    translateKey: string,
    type: 'title' | 'collapse' | 'item',
    iconType?: '' | 'feather' | 'line-awesome';
    icon?: string;
    submenu : NavMenu[];
    key: string
}
`

    constructor() { }

    ngOnInit() {
        if (typeof PR !== 'undefined') {
            setTimeout(() => PR.prettyPrint(), 10);
        }
    }
}