import { NgModule } from '@angular/core';
import { routes } from './icons.routing.module';
import { RouterModule } from '@angular/router';
import { SharedModule } from '@app/shared/shared.module';
import { ToastrModule } from 'ngx-toastr';
import { TabsModule } from 'ngx-bootstrap/tabs';

import { IconsComponent } from './icons.component';

@NgModule({
    imports: [
        SharedModule,
        ToastrModule.forRoot(),
        TabsModule.forRoot(),
        RouterModule.forChild(routes) 
    ],
    declarations: [
        IconsComponent
    ]
})
export class IconsModule {}