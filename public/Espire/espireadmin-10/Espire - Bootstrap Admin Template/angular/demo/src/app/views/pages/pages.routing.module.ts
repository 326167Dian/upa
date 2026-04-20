import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

const routes: Routes = [
    {
        path: 'profile',
        loadChildren: () => import('./profile/profile.module').then(m => m.ProfileModule)
    },
    {
        path: 'invoice',
        loadChildren: () => import('./invoice/invoice.module').then(m => m.InvoiceModule)
    },
    {
        path: 'faq',
        loadChildren: () => import('./faq/faq.module').then(m => m.FaqModule)
    },
    {
        path: 'pricing',
        loadChildren: () => import('./pricing/pricing.module').then(m => m.PricingModule)
    },
    {
        path: 'user-list',
        loadChildren: () => import('./user-list/user-list.module').then(m => m.UserListModule)
    },
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule],
})
export class PagesRoutingModule { }
