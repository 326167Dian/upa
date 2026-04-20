import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

const routes: Routes = [
    {
        path: 'apex-chart',
        loadChildren: () => import('./apex-chart/demo-apex-chart.module').then(m => m.DemoApexChartModule)
    }
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule],
})
export class ChartRoutingModule { }
