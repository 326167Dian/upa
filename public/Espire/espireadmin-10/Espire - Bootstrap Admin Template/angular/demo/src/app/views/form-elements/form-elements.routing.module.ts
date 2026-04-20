import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

const routes: Routes = [
    {
        path: 'input',
        loadChildren: () => import('./input/demo-input.module').then(m => m.DemoInputModule)
    },
    {
        path: 'radio',
        loadChildren: () => import('./radio/demo-radio.module').then(m => m.DemoRadioModule)
    },
    {
        path: 'checkbox',
        loadChildren: () => import('./checkbox/demo-checkbox.module').then(m => m.DemoCheckboxModule)
    },
    {
        path: 'switch',
        loadChildren: () => import('./switch/demo-switch.module').then(m => m.DemoSwitchModule)
    },
    {
        path: 'select',
        loadChildren: () => import('./select/demo-select.module').then(m => m.DemoSelectModule)
    },
    {
        path: 'form',
        loadChildren: () => import('./form/demo-form.module').then(m => m.DemoFormModule)
    },
    {
        path: 'upload',
        loadChildren: () => import('./upload/demo-upload.module').then(m => m.DemoUploadModule)
    },
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule],
})
export class FormElementsRoutingModule { }
