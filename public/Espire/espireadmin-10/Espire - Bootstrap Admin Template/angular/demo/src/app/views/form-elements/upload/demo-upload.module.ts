import { NgModule } from '@angular/core';
import { SharedModule } from '@app/shared/shared.module';
import { RouterModule } from '@angular/router';
import { UploadSectionComponent } from './upload-section.component';
import { DEMO_COMPONENTS } from './demos';
import { DocsModule } from '@app/shared/components/docs';
import { routes } from './demo-upload.routes';
import { UploadModule } from '@app/shared/components/upload/upload.module'
import { ModalModule } from 'ngx-bootstrap/modal';

@NgModule({
  declarations: [
    UploadSectionComponent,
    ...DEMO_COMPONENTS
  ],
  imports: [
    SharedModule,
    DocsModule,
    UploadModule.forRoot(),
    ModalModule.forRoot(),
    RouterModule.forChild(routes)
  ],
  exports: [UploadSectionComponent],
  entryComponents: [...DEMO_COMPONENTS]
})
export class DemoUploadModule {
  static routes: any = routes;
}
