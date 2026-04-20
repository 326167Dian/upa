import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

const routes: Routes = [
    {
        path: 'ammap',
        loadChildren: () => import('./ammap/demo-ammap.module').then(m => m.DemoAmMapModule)
    },
    {
        path: 'google-map',
        loadChildren: () => import('./google-map/demo-google-map.module').then(m => m.DemoGoogleMapModule)
    }
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule],
})
export class MapsRoutingModule { }
