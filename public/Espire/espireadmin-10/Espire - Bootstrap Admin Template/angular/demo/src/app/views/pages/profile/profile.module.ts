import { NgModule } from '@angular/core';
import { SharedModule } from '@app/shared/shared.module';
import { routes } from './profile.routing.module';
import { RouterModule } from '@angular/router';
import { ColumnPanelModule } from '@app/shared/components/column-panel/column-panel.module';
import { RadioModule } from '@app/shared/components/radio/radio.module';
import { NgBootstrapFormValidationModule } from 'ng-bootstrap-form-validation';
import { BsDatepickerModule } from 'ngx-bootstrap/datepicker';
import { UploadModule } from '@app/shared/components/upload/upload.module'
import { SwitchModule } from '@app/shared/components/switch/switch.module';
import { ToastrModule } from 'ngx-toastr';

import { RowContentComponent } from './row-content/row-content.component';
import { ProfileComponent } from './profile.component';
import { PersonalComponent } from './personal/personal.component';
import { NotificationComponent } from './notification/notification.component';
import { SecurityComponent } from './security/security.component'
import { SocialConnectComponent } from './social-connect/social-connect.component'

@NgModule({
    declarations: [
        ProfileComponent,
        PersonalComponent,
        NotificationComponent,
        SecurityComponent,
        SocialConnectComponent,
        RowContentComponent
    ],
    imports: [ 
        SharedModule,
        ColumnPanelModule,
        RadioModule,
        BsDatepickerModule.forRoot(),
        UploadModule.forRoot(),
        SwitchModule,
        ToastrModule.forRoot(),
        NgBootstrapFormValidationModule.forRoot(),
        RouterModule.forChild(routes)
    ],
    exports: [],
    providers: [],
})
export class ProfileModule {}