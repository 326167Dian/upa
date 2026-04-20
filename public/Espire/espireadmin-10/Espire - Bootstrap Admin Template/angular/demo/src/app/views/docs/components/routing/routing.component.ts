import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'routing',
    templateUrl: 'routing.component.html'
})

export class RoutingComponent implements OnInit {
    constructor() { }

    ngOnInit() {
        if (typeof PR !== 'undefined') {
            setTimeout(() => PR.prettyPrint(), 10);
        }
    }

    routeExampleSyntax: string = `import { Routes } from '@angular/router';

export const APP_LAYOUT_ROUTES: Routes = [
    //Dashboard
    {
        path: 'dashboard',
        loadChildren: () => import('../views/dashboard/dashboard.module').then(m => m.DashboardModule),
    }
]`

    routeMetadataSyntax: string = `{
    title: string, // Page Header Title
    hidePageHeader: boolean // Whether to hide PageHeader 
}`

exampleRouteSyntax: string = `{
    path: 'with-page-header',
    loadChildren: () => import('./with-page-header/with-page-header.module').then(m => m.WithPageHeaderModule),
    data: {
        title: 'My PageHeader Title',
        hidePageHeader: false
    }
},{
    path: 'without-page-header',
    loadChildren: () => import('./without-page-header/without-page-header.module').then(m => m.WithoutPageHeaderModule),
    data: {
        title: '',
        hidePageHeader: true
    }
}`
}