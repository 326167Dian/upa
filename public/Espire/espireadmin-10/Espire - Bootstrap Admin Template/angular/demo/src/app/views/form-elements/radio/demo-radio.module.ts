import { NgModule } from '@angular/core';
import { SharedModule } from '@app/shared/shared.module';
import { RouterModule } from '@angular/router';
import { RadioSectionComponent } from './radio-section.component';
import { DEMO_COMPONENTS } from './demos';
import { DocsModule } from '@app/shared/components/docs';
import { RadioModule } from '@app/shared/components/radio/radio.module';

import { routes } from './demo-radio.routes';

@NgModule({
  declarations: [
    RadioSectionComponent,
    ...DEMO_COMPONENTS
  ],
  imports: [
    SharedModule,
    DocsModule,
    RadioModule,
    RouterModule.forChild(routes)
  ],
  exports: [RadioSectionComponent],
  entryComponents: [...DEMO_COMPONENTS]
})
export class DemoRadioModule {
  static routes: any = routes;
}
