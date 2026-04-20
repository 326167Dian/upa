import { NgModule } from '@angular/core';
import { SharedModule } from '@app/shared/shared.module';
import { RouterModule } from '@angular/router';
import { AmMapSectionComponent } from './ammap-section.component';
import { DEMO_COMPONENTS } from './demos';
import { DocsModule } from '@app/shared/components/docs';
import { routes } from './demo-ammap.routes';

@NgModule({
  declarations: [
    AmMapSectionComponent,
    ...DEMO_COMPONENTS
  ],
  imports: [
    SharedModule,
    DocsModule,
    RouterModule.forChild(routes)
  ],
  exports: [AmMapSectionComponent],
  entryComponents: [...DEMO_COMPONENTS]
})
export class DemoAmMapModule {
  static routes: any = routes;
}
