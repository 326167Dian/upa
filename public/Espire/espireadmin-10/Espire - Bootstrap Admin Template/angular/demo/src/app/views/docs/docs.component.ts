import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'docs',
    templateUrl: 'docs.component.html'
})

export class DocsComponent implements OnInit {

    docNavTree = [
        {
            path:'/getting-started',
            title: 'Getting Started'
        },
        {
            path:'/product-content',
            title: 'Product Content'
        },
        {
            path:'/folder-structure',
            title: 'Folder Structure'
        },
        {
            path:'/installation',
            title: 'Installation'
        },
        {
            path:'/updating',
            title: 'Updating'
        },
        {
            path:'/template-setting',
            title: 'Template Setting'
        },
        {
            path:'/routing',
            title: 'Routing'
        },
        {
            path:'/language',
            title: 'Language'
        },
        {
            path:'/menu-structure',
            title: 'Menu Structure'
        },
        {
            path:'/changelog',
            title: 'Changelog'
        }
    ]

    constructor() { }

    ngOnInit() { }
}