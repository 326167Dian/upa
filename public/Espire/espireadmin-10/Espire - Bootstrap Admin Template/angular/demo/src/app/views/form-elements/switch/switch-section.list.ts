import { DemoSwitchBasicComponent } from './demos/basic/basic';
import { DemoSwitchDisabledComponent } from './demos/disabled/disabled';
import { DemoSwitchWithFormComponent } from './demos/withForm/withForm';

import { ContentSection } from '@app/shared/components/docs/models/content-section.model';
import { DemoTopSectionComponent } from '@app/shared/components/docs/demo-section-components/demo-top-section/index';
import { ExamplesComponent } from '@app/shared/components/docs/demo-section-components/demo-examples-section/index';
import { ApiSectionsComponent } from '@app/shared/components/docs/demo-section-components/demo-api-section/index';

import {
  NgApiDocComponent
} from '@app/shared/components/docs/api-docs';

export const demoComponentContent: ContentSection[] = [
  {
    name: 'Usage',
    anchor: 'usage',
    outlet: DemoTopSectionComponent,
    content: {
      doc: require('!!raw-loader!./docs/usage.md')
    }
  },
  {
    name: 'Examples',
    anchor: 'examples',
    outlet: ExamplesComponent,
    content: [
      {
        title: 'Basic',
        anchor: 'basic',
        description: `<p>Basic usage</p>`,
        component: require('!!raw-loader!./demos/basic/basic'),
        html: require('!!raw-loader!./demos/basic/basic.html'),
        outlet: DemoSwitchBasicComponent
      },
      {
        title: 'Disabled',
        anchor: 'Disabled',
        description: `<p>Disabled switch </p>`,
        component: require('!!raw-loader!./demos/disabled/disabled'),
        html: require('!!raw-loader!./demos/disabled/disabled.html'),
        outlet: DemoSwitchDisabledComponent
      },
      {
        title: 'With Form',
        anchor: 'withForm',
        description: `<p>Usage with form</p>`,
        component: require('!!raw-loader!./demos/withForm/withForm'),
        html: require('!!raw-loader!./demos/withForm/withForm.html'),
        outlet: DemoSwitchWithFormComponent
      },
    ]
  },
  {
    name: 'API Reference',
    anchor: 'api-reference',
    outlet: ApiSectionsComponent,
    content: [
      {
        title: 'SwitchComponent',
        anchor: 'switch-component',
        outlet: NgApiDocComponent
      }
    ]
  }
];
