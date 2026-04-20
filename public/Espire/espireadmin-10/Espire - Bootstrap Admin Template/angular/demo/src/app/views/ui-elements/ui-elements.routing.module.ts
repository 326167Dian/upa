import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';


const routes: Routes = [
    {
        path: 'accordion',
        loadChildren: () => import('./accordion/demo-accordion.module').then(m => m.DemoAccordionModule)
    },
    {
        path: 'alert',
        loadChildren: () => import('./alerts/demo-alert.module').then(m => m.DemoAlertsModule)
    },
    {
        path: 'buttons',
        loadChildren: () => import('./button/demo-buttons.module').then(m => m.DemoButtonsModule)
    },
    {
        path: 'carousel',
        loadChildren: () => import('./carousel/demo-carousel.module').then(m => m.DemoCarouselModule)
    },
    {
        path: 'collapse',
        loadChildren: () => import('./collapse/demo-collapse.module').then(m => m.DemoCollapseModule)
    },
    {
        path: 'datepicker',
        loadChildren: () => import('./datepicker/demo-datepicker.module').then(m => m.DemoDatepickerModule)
    },
    {
        path: 'dropdown',
        loadChildren: () => import('./dropdown/demo-dropdown.module').then(m => m.DemoDropdownModule)
    },
    {
        path: 'modal',
        loadChildren: () => import('./modal/demo-modal.module').then(m => m.DemoModalModule)
    },
    {
        path: 'pagination',
        loadChildren: () => import('./pagination/demo-pagination.module').then(m => m.DemoPaginationModule)
    },
    {
        path: 'popover',
        loadChildren: () => import('./popover/demo-popover.module').then(m => m.DemoPopoverModule)
    },
    {
        path: 'progressbar',
        loadChildren: () => import('./progressbar/demo-progressbar.module').then(m => m.DemoProgressbarModule)
    },
    {
        path: 'rating',
        loadChildren: () => import('./rating/demo-rating.module').then(m => m.DemoRatingModule)
    },
    {
        path: 'sortable',
        loadChildren: () => import('./sortable/demo-sortable.module').then(m => m.DemoSortableModule)
    },
    {
        path: 'tabs',
        loadChildren: () => import('./tabs/demo-tabs.module').then(m => m.DemoTabsModule)
    },
    {
        path: 'timepicker',
        loadChildren: () => import('./timepicker/demo-timepicker.module').then(m => m.DemoTimepickerModule)
    },
    {
        path: 'tooltip',
        loadChildren: () => import('./tooltip/demo-tooltip.module').then(m => m.DemoTooltipModule)
    },
    {
        path: 'typehead',
        loadChildren: () => import('./typehead/demo-typeahead.module').then(m => m.DemoTypeaheadModule)
    },
    
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule],
})
export class UiElementsRoutingModule { }
