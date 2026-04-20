import { Routes } from '@angular/router';

export const APP_LAYOUT_ROUTES: Routes = [
    //Dashboard
    {
        path: 'dashboard',
        loadChildren: () => import('../views/dashboard/dashboard.module').then(m => m.DashboardModule),
    },
    //Apps
    {
        path: 'apps',
        loadChildren: () => import('../views/apps/apps.module').then(m => m.AppsModule),
    },
    // UI Elements
    {
        path: 'ui-elements',
        loadChildren: () => import('../views/ui-elements/ui-elements.module').then(m => m.UiElementsModule),
    },
    // Icons 
    {
        path: 'icons',
        loadChildren: () => import('../views/icons/icons.module').then(m => m.IconsModule),
    },
    {
        path: 'maps',
        loadChildren: () => import('../views/maps/maps.module').then(m => m.MapsModule),
    },
    // Chart  
    {
        path: 'charts',
        loadChildren: () => import('../views/charts/charts.module').then(m => m.ChartsModule),
    },
    // Form Elements
    {
        path: 'form-elements',
        loadChildren: () => import('../views/form-elements/form-elements.module').then(m => m.FormElementsModule),
    },
    // Tables  
    {
        path: 'tables',
        loadChildren: () => import('../views/tables/tables.module').then(m => m.TablesModule),
    },
    // Pages  
    {
        path: 'pages',
        loadChildren: () => import('../views/pages/pages.module').then(m => m.PagesModule),
    },
    // Docs  
    {
        path: 'docs',
        loadChildren: () => import('../views/docs/docs.module').then(m => m.DocsModule),
    }
];