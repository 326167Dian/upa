import { NgModule } from '@angular/core';
import { SharedModule } from '@app/shared/shared.module';
import { routes } from './user-list.routing.module';
import { RouterModule } from '@angular/router';
import { NgxDatatableModule } from '@swimlane/ngx-datatable';
import { UserListComponent } from './user-list.component';
import { AvatarModule } from '@app/shared/components/avatar/avatar.module';
import { DropdownModule } from '@app/shared/components/dropdown/dropdown.module';

@NgModule({
    declarations: [UserListComponent],
    imports: [ 
        SharedModule,
        NgxDatatableModule,
        AvatarModule,
        DropdownModule,
        RouterModule.forChild(routes)
    ],
    exports: [],
    providers: [],
})
export class UserListModule {}