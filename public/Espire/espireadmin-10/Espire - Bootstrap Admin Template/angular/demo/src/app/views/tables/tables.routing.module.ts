import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

const routes: Routes = [
    {
        path: 'table',
        loadChildren: () => import('./table/demo-table.module').then(m => m.DemoTableModule)
    },
    {
        path: 'data-table',
        loadChildren: () => import('./data-table/demo-data-table.module').then(m => m.DemoDataTableModule)
    }
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule],
})
export class TablesRoutingModule { }
