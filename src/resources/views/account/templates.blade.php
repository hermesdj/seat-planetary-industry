@extends('seat-pi::account.layouts.view', ['viewname' => 'templates'])

@section('page_header', trans('seat-pi::templates.page.header'))

@push('javascript')
    <script>
        $(document).ready(function() {
            const commandCenters = @json($commandCenters);
            const planetMapping = @json($planetMapping);
            const planetTypes = @json($planetTypes);
            const productMapping = @json($productMapping);
            const resourceMapping = @json($resourceMapping);
            const structures = @json($structures);

            /**
             * Stringify an object with floats to a specified number of decimal places.
             * 
             * Note: Needed because CCP uses a JSON-like format where 1.0 becomes 1 and that invalidates the template.
             *       This function tries to preserve the decimals, even for 1.0, and royally adds 5 decimals to everything.
             * 
             * @argument {Object} config The configuration object.
             * @argument {number} decimals The number of decimal places to round to.
             * @returns {Function} The stringifyWithFloats function.
             */
            const stringifyWithFloats =
                (config = {}, decimals = 1) =>
                (inputValue, inputReplacer, space) => {
                    const beginFloat = "~begin~float~";
                    const endFloat = "~end~float~";
                    const inputReplacerIsFunction = typeof inputReplacer === "function";
                    let isFirstIteration = true;
                    const jsonReplacer = (key, val) => {
                        if (isFirstIteration) {
                            isFirstIteration = false;
                            return inputReplacerIsFunction ? inputReplacer(key, val) : val;
                        }
                        let value;
                        if (inputReplacerIsFunction) {
                            value = inputReplacer(key, val);
                        } else if (Array.isArray(inputReplacer)) {
                            // remove the property if it is not included in the inputReplacer array
                            value = inputReplacer.indexOf(key) !== -1 ? val : undefined;
                        } else {
                            value = val;
                        }
                        const forceFloat =
                            config[key] === "float" &&
                            (value || value === 0) &&
                            typeof value === "number" &&
                            !value.toString().toLowerCase().includes("e");
                        return forceFloat ? `${beginFloat}${value}${endFloat}` : value;
                    };
                    const json = JSON.stringify(inputValue, jsonReplacer, space);
                    const regexReplacer = (match, num) => {
                        return num.includes(".") || Number.isNaN(num) ?
                            Number.isNaN(num) ?
                            num :
                            Number(num).toFixed(decimals) :
                            `${num}.${"0".repeat(decimals)}`;
                    };
                    const re = new RegExp(`"${beginFloat}(.+?)${endFloat}"`, "g");
                    return json.replace(re, regexReplacer);
                };

            /** 
             * Generate a list of links.
             * 
             * @TODO Static list for now, needs to be dynamic.
             * 
             * @param {number} factories The number of factories.
             * @returns {Object[]} The list of links.
             */
            const generateLinks = (factories) => {
                const links = [{
                        "D": 2,
                        "Lv": 0,
                        "S": 3
                    },
                    {
                        "D": 2,
                        "Lv": 0,
                        "S": 4
                    },
                    {
                        "D": 3,
                        "Lv": 0,
                        "S": 5
                    },
                    {
                        "D": 4,
                        "Lv": 0,
                        "S": 6
                    },
                    {
                        "D": 5,
                        "Lv": 0,
                        "S": 7
                    },
                    {
                        "D": 6,
                        "Lv": 0,
                        "S": 8
                    },
                    {
                        "D": 3,
                        "Lv": 0,
                        "S": 9
                    },
                    {
                        "D": 4,
                        "Lv": 0,
                        "S": 10
                    },
                    {
                        "D": 5,
                        "Lv": 0,
                        "S": 11
                    },
                    {
                        "D": 6,
                        "Lv": 0,
                        "S": 12
                    },
                    {
                        "D": 7,
                        "Lv": 0,
                        "S": 13
                    },
                    {
                        "D": 8,
                        "Lv": 0,
                        "S": 14
                    }
                ];
                return links.slice(0, factories);
            }

            /** 
             * Generate a list of routes.
             * 
             * @TODO Static list for now, needs to be dynamic.
             * 
             * @param {number} factories The number of factories.
             * @param {number} productTypeId The type of the product.
             * @param {number} resourceTypeId The type of the resource.
             * @returns {Object[]} The list of routes.
             */
            const generateRoutes = (factories, productTypeId, resourceTypeId) => {
                const resourceRoutes = [{
                        "P": [
                            2, // Storage
                            3, // Factory 1
                        ],
                        "Q": 3000,
                        "T": resourceTypeId,
                    },
                    {
                        "P": [
                            2, // Storage
                            4, // Factory 2
                        ],
                        "Q": 3000,
                        "T": resourceTypeId,
                    },
                    {
                        "P": [
                            2, // Storage
                            3, // Factory 1
                            5, // Factory 3
                        ],
                        "Q": 3000,
                        "T": resourceTypeId,
                    },
                    {
                        "P": [
                            2, // Storage
                            4, // Factory 2
                            6, // Factory 4
                        ],
                        "Q": 3000,
                        "T": resourceTypeId,
                    },
                    {
                        "P": [
                            2, // Storage
                            3, // Factory 1
                            5, // Factory 3
                            7, // Factory 5
                        ],
                        "Q": 3000,
                        "T": resourceTypeId,
                    },
                    {
                        "P": [
                            2, // Storage
                            4, // Factory 2
                            6, // Factory 4
                            8, // Factory 6
                        ],
                        "Q": 3000,
                        "T": resourceTypeId,
                    },
                    {
                        "P": [
                            2, // Storage
                            3, // Factory 1
                            9, // Factory 7
                        ],
                        "Q": 3000,
                        "T": resourceTypeId,
                    },
                    {
                        "P": [
                            2, // Storage
                            4, // Factory 2
                            10, // Factory 8
                        ],
                        "Q": 3000,
                        "T": resourceTypeId,
                    },
                    {
                        "P": [
                            2, // Storage
                            3, // Factory 1
                            5, // Factory 3
                            11, // Factory 9
                        ],
                        "Q": 3000,
                        "T": resourceTypeId,
                    },
                    {
                        "P": [
                            2, // Storage
                            4, // Factory 2
                            6, // Factory 4
                            12, // Factory 10
                        ],
                        "Q": 3000,
                        "T": resourceTypeId,
                    },
                    {
                        "P": [
                            2, // Storage
                            3, // Factory 1
                            5, // Factory 3
                            7, // Factory 5
                            13, // Factory 11
                        ],
                        "Q": 3000,
                        "T": resourceTypeId,
                    },
                    {
                        "P": [
                            2, // Storage
                            4, // Factory 2
                            6, // Factory 4
                            8, // Factory 6
                            14, // Factory 12
                        ],
                        "Q": 3000,
                        "T": resourceTypeId,
                    }
                ];
                const productRoutes = [{
                        "P": [
                            3, // Factory 1
                            2, // Storage
                            1, // Launchpad
                        ],
                        "Q": 20,
                        "T": productTypeId,
                    },
                    {
                        "P": [
                            4, // Factory 2
                            2, // Storage
                            1, // Launchpad
                        ],
                        "Q": 20,
                        "T": productTypeId,
                    },
                    {
                        "P": [
                            5, // Factory 3
                            3, // Factory 1
                            2, // Storage
                            1, // Launchpad
                        ],
                        "Q": 20,
                        "T": productTypeId,
                    },
                    {
                        "P": [
                            6, // Factory 4
                            4, // Factory 2
                            2, // Storage
                            1, // Launchpad
                        ],
                        "Q": 20,
                        "T": productTypeId,
                    },
                    {
                        "P": [
                            7, // Factory 5
                            5, // Factory 3
                            3, // Factory 1
                            2, // Storage
                            1, // Launchpad
                        ],
                        "Q": 20,
                        "T": productTypeId,
                    },
                    {
                        "P": [
                            8, // Factory 6
                            6, // Factory 4
                            4, // Factory 2
                            2, // Storage
                            1, // Launchpad
                        ],
                        "Q": 20,
                        "T": productTypeId,
                    },
                    {
                        "P": [
                            9, // Factory 7
                            3, // Factory 1
                            2, // Storage
                            1, // Launchpad
                        ],
                        "Q": 20,
                        "T": productTypeId,
                    },
                    {
                        "P": [
                            10, // Factory 8
                            4, // Factory 2
                            2, // Storage
                            1, // Launchpad
                        ],
                        "Q": 20,
                        "T": productTypeId,
                    },
                    {
                        "P": [
                            11, // Factory 9
                            5, // Factory 3
                            3, // Factory 1
                            2, // Storage
                            1, // Launchpad
                        ],
                        "Q": 20,
                        "T": productTypeId,
                    },
                    {
                        "P": [
                            12, // Factory 10
                            6, // Factory 4
                            4, // Factory 2
                            2, // Storage
                            1, // Launchpad
                        ],
                        "Q": 20,
                        "T": productTypeId,
                    },
                    {
                        "P": [
                            13, // Factory 11
                            7, // Factory 5
                            5, // Factory 3
                            3, // Factory 1
                            2, // Storage
                            1, // Launchpad
                        ],
                        "Q": 20,
                        "T": productTypeId,
                    },
                    {
                        "P": [
                            14, // Factory 12
                            8, // Factory 6
                            6, // Factory 4
                            4, // Factory 2
                            2, // Storage
                            1, // Launchpad
                        ],
                        "Q": 20,
                        "T": productTypeId,
                    }
                ];

                return [
                    ...productRoutes.slice(0, factories),
                    ...resourceRoutes.slice(0, factories),
                ]
            }

            /**
             * Generate a launch pad object.
             * 
             * @param {number} typeId The type ID of the launch pad.
             * @returns {Object} The launch pad object.
             */
            const generateLaunchPad = (typeId = 2544) => {
                return {
                    H: 0,
                    La: 1.0 - 0.012020,
                    Lo: 1.0,
                    S: null,
                    T: typeId || 2544
                };
            }

            /** 
             * Generate a storage facility object.
             * 
             * @TODO Consider making this optional.
             * 
             * @param {number} typeId The type ID of the storage facility.
             * @returns {Object} The storage facility object.
             */
            const generateStorageFacility = (typeId = 2541) => {
                return {
                    H: 0,
                    La: 1.0,
                    Lo: 1.0,
                    S: null,
                    T: typeId
                };
            }

            /** 
             * Generate an extractor control unit object.
             * 
             * @TODO Consider making this optional.
             * 
             * @param {number} typeId The type ID of the extractor control unit.
             * @returns {Object} The extractor control unit object.
             */
            const generateExtractorControlUnit = (typeId = 2848) => {
                return {
                    H: 0,
                    La: 1.0 + 0.012020,
                    Lo: 1.0,
                    S: null,
                    T: typeId
                };
            }

            /**
             * Generate a list of factories.
             * 
             * @param {number} count The number of factories to generate.
             * @param {number} typeId The type ID of the factory.
             * @param {number} productId The product ID of the factory.
             * @param {number} baseLo The base Lo value.
             * @param {number} offsetLo The offset Lo value.
             * @param {number} rowOffsetLa The row offset La value.
             * @returns {Object[]} The list of factories.
             */
            const generateFactories = (count, typeId = 2473, productId = 2393, baseLo = 1.0, offsetLo = 0.014390,
                rowOffsetLa = -0.012020) => {
                return Array.from({
                    length: count
                }, (_, i) => {
                    const isSecondRow = i >= 6;
                    const rowIndex = isSecondRow ? i - 6 : i; // Restart index for second row
                    const adjustment = (rowIndex % 2 === 0 ? -1 : 1) * offsetLo * Math.ceil((rowIndex +
                        1) / 2);
                    const Lo = baseLo + adjustment;

                    // Prevent Lo from being exactly 1.0
                    if (Lo === 1.0) Lo += offsetLo;

                    return {
                        H: 0,
                        La: isSecondRow ? 1.0 + rowOffsetLa : 1.0, // Shift row for La after 6th
                        Lo: Lo, // Reset and recalculate Lo properly
                        S: productId,
                        T: typeId,
                    };
                });
            }

            /**
             * Generate a template.
             * 
             * @param {number} commandCenterLevel The command center level.
             * @param {number} factories The number of factories.
             * @param {string} planetName The name of the planet.
             * @param {number} planetTypeId The type of the planet.
             * @param {string} productName The name of the product.
             * @param {number} productTypeId The type of the product.
             * @param {number} resourceTypeId The type of the resource.
             * @returns {string} The template.
             */
            const generateTemplate = (commandCenterLevel = 0, factories = 10, planetName, planetTypeId, productName,
                productTypeId,
                resourceTypeId) => {

                const jsonOutput = {
                    'CmdCtrLv': commandCenterLevel,
                    'Cmt': `${planetName} - Extraction - ${productName}`,
                    'Diam': 4400.0,
                    'L': [
                        // Storage facility to launch pad
                        {
                            "D": 1,
                            "Lv": 0,
                            "S": 2
                        },
                        ...generateLinks(factories)
                    ],
                    'P': [
                        // Always include the launch pad
                        generateLaunchPad(planetMapping[planetTypeId].launchPad),

                        // Always include the storage facility
                        generateStorageFacility(planetMapping[planetTypeId].storageFacility),

                        // Factories
                        ...generateFactories(factories, planetMapping[planetTypeId].basicFactory,
                            productTypeId)
                    ],
                    'Pln': parseInt(planetTypeId),
                    'R': [
                        ...generateRoutes(factories, productTypeId, resourceTypeId)
                    ]
                };

                if ($('#extractor').is(':checked')) {
                    jsonOutput.P.push(generateExtractorControlUnit(planetMapping[planetTypeId].extractor));
                    jsonOutput.L.push({
                        "D": 2,
                        "Lv": 0,
                        "S": jsonOutput.P.length
                    });
                }

                return stringifyWithFloats({
                    Diam: "float",
                    La: "float",
                    Lo: "float",
                }, 6)(jsonOutput, null, 2);
            }

            /**
             * Get the configurator data.
             * 
             * @returns {Object} The configurator data.
             */
            const getConfiguratorData = () => {
                const planetName = $('#planetType').find(':selected').text();
                const productName = $('#productType').find(':selected').text();

                return {
                    commandCenterLevel: parseInt($('#commandCenterLevel').val()) || 0,
                    factories: parseInt($('#factories').val()) || 10,
                    planetName,
                    planetTypeId: parseInt($('#planetType').val()),
                    productName,
                    productTypeId: parseInt($('#productType').find(':selected').data('product-id')),
                    resourceTypeId: parseInt($('#productType').find(':selected').data('resource-id')),
                    templateName: `${planetName.toLowerCase().replace(/ /g, '_')}_extraction_${productName.toLowerCase().replace(/ /g, '_')}_template.json`
                };
            }

            /**
             * Copy the template to the clipboard.
             * 
             * @returns {void}
             */
            const onCopyHandler = () => {
                const {
                    commandCenterLevel,
                    factories,
                    planetName,
                    planetTypeId,
                    productName,
                    productTypeId,
                    resourceTypeId
                } = getConfiguratorData();

                const template = generateTemplate(commandCenterLevel, factories, planetName, planetTypeId,
                    productName,
                    productTypeId, resourceTypeId);

                navigator.clipboard.writeText(template).then(() => {
                    const copyButton = $('#copyButton');
                    copyButton.removeClass('btn-primary').addClass('btn-success');
                    setTimeout(() => {
                        copyButton.removeClass('btn-success').addClass('btn-primary');
                    }, 2000);
                }).catch(err => {
                    console.error('Failed to copy template: ', err);
                });
            }

            /**
             * Download the template.
             * 
             * @returns {void}
             */
            const onDownloadHandler = () => {
                const {
                    commandCenterLevel,
                    factories,
                    planetName,
                    planetTypeId,
                    productName,
                    productTypeId,
                    resourceTypeId,
                    templateName
                } = getConfiguratorData();

                const template = generateTemplate(commandCenterLevel, factories, planetName, planetTypeId,
                    productNameId, productTypeId, resourceTypeId);

                const blob = new Blob([template], {
                    type: 'application/json'
                });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = templateName;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }

            /**
             * Update the planet options based on the selected resource type.
             * 
             * This function is called when the resource type changes.
             * It filters the planet options based on the selected resource type.
             * It also filters the planetOverview datatable based on the selected resource type.
             * 
             * @returns {void}
             */
            function updateConfigurator() {
                const characterSkillLevel = parseInt($('#character').find(':selected').data('skill-level'));
                const selectedProductType = parseInt($('#productType').val());
                const allowedPlanetIds = productMapping[selectedProductType].planets || [];

                // Clear existing options.
                $('#planetType').empty();

                // Add new options based on the mapping.
                planetTypes.forEach((planetType) => {
                    if (!allowedPlanetIds.includes(planetType.typeID)) {
                        return;
                    }

                    const isSelected = planetType.typeID ==
                        {{ request()->get('planetTypeId') ? request()->get('planetTypeId') : 'null' }};
                    $('#planetType')
                        .append($('<option>', {
                            'data-planet-type-id': planetType.typeID,
                            selected: isSelected,
                            text: planetType.typeName,
                            value: planetType.typeID,
                        }));
                });

                $('#productTypeHelp').text(
                    `{{ trans('seat-pi::templates.configurator.made_from') }} ${resourceMapping[productMapping[selectedProductType].resource].name}`
                );

                // Select the highest possible value allowed by the skill level.
                const highestAllowedLevel = Math.min(
                    characterSkillLevel,
                    $('#commandCenterLevel option').length
                );
                $('#commandCenterLevel').val(highestAllowedLevel);

                // Limit the enabled options in commandCenterLevel based on characterSkillLevel.
                $('#commandCenterLevel option').each(function() {
                    const optionValue = parseInt($(this).val());
                    if (optionValue > characterSkillLevel) {
                        $(this).prop('disabled', true);
                    } else {
                        $(this).prop('disabled', false);
                    }
                });

                // Update power and cpu values.
                updateConfiguratorCpuPowerProvided.bind($('#commandCenterLevel').get(0))();
                updateConfiguratorFactoryPowerRequired.bind($('#factories').get(0))();
                updateConfiguratorConsumption();

                // Filter the planetOverview datatable.
                const table = $('#planetOverviewTable').DataTable();
                table.order([2, 'asc']).draw();

                $.fn.dataTable.ext.search = [];
                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    const planetId = parseInt($(table.row(dataIndex).node()).data('planet-type-id'));
                    return allowedPlanetIds.includes(planetId);
                });

                table.draw();
            }

            /**
             * Update the power and cpu provided by the command center level.
             * 
             * @returns {void}
             */
            function updateConfiguratorCpuPowerProvided() {
                const selectedOption = $(this).find(':selected');
                const cpuProvided = selectedOption.data('cpu-provided');
                const powerProvided = selectedOption.data('power-provided');

                $('#commandCenterLevelHelp').text(
                    `{{ trans('seat-pi::templates.configurator.available') }}: ${powerProvided} MW / ${cpuProvided} TF`
                )
            }

            /**
             * Update the power required by the factories.
             * 
             * @returns {void}
             */
            function updateConfiguratorFactoryPowerRequired() {
                const selectedOption = $(this).find(':selected');
                const factories = parseInt(selectedOption.val());
                const cpuRequired = factories * selectedOption.data('cpu-required');
                const powerRequired = factories * selectedOption.data('power-required');

                $('#factoriesHelp').text(
                    `{{ trans('seat-pi::templates.configurator.required') }}: ${powerRequired} MW / ${cpuRequired} TF`
                )
            }

            /**
             * Update the power and cpu consumption.
             * 
             * @returns {void}
             */
            function updateConfiguratorConsumption() {
                const cpuProvided = parseInt($('#commandCenterLevel')
                    .find(':selected')
                    .data('cpu-provided'));
                const powerProvided = parseInt($('#commandCenterLevel')
                    .find(':selected')
                    .data('power-provided'));

                const factories = parseInt($('#factories').val());
                const factoryCpuRequired = factories * parseInt($('#factories')
                    .find(':selected')
                    .data('cpu-required'));
                const factoryPowerRequired = factories * parseInt($('#factories')
                    .find(':selected')
                    .data('power-required'));

                const extractorEnabled = $('#extractor').is(':checked');

                // Links and structures in the template, without compressed pins, consume below cpu and power.
                const linkLoad = {
                    cpuRequired: 21,
                    powerRequired: 14,
                };

                // Predefine common structure lookups
                const getStructure = (name) => structures.find((structure) => structure.name === name);

                // Structure loads
                const basicFactory = getStructure('Basic Industry Facility');
                const storageFacility = getStructure('Storage Facility');
                const launchPad = getStructure('Launchpad');
                const extractorControlUnit = getStructure('Extractor Control Unit');
                const extractorHead = getStructure('Extractor Head');

                const cpuConsumed = factoryCpuRequired +
                    linkLoad.cpuRequired +
                    (linkLoad.cpuRequired * factories) +
                    storageFacility.cpuRequired +
                    launchPad.cpuRequired +
                    (extractorEnabled ? extractorControlUnit.cpuRequired : 0) +
                    (extractorEnabled ? extractorHead.cpuRequired * 10 : 0);

                const powerConsumed = factoryPowerRequired +
                    linkLoad.powerRequired +
                    (linkLoad.powerRequired * factories) +
                    storageFacility.powerRequired +
                    launchPad.powerRequired +
                    (extractorEnabled ? extractorControlUnit.powerRequired : 0) +
                    (extractorEnabled ? extractorHead.powerRequired * 10 : 0);

                const cpuRemaining = cpuProvided -
                    factoryCpuRequired -
                    linkLoad.cpuRequired -
                    (linkLoad.cpuRequired * factories) -
                    storageFacility.cpuRequired -
                    launchPad.cpuRequired -
                    (extractorEnabled ? extractorControlUnit.cpuRequired : 0) -
                    (extractorEnabled ? extractorHead.cpuRequired * 10 : 0);

                const powerRemaining = powerProvided -
                    factoryPowerRequired -
                    linkLoad.powerRequired -
                    (linkLoad.powerRequired * factories) -
                    storageFacility.powerRequired -
                    launchPad.powerRequired -
                    (extractorEnabled ? extractorControlUnit.powerRequired : 0) -
                    (extractorEnabled ? extractorHead.powerRequired * 10 : 0);

                const factoryCount = parseInt($('#factories').val());
                const buildCost = (basicFactory.cost * factoryCount) +
                    storageFacility.cost +
                    launchPad.cost +
                    (extractorEnabled ? extractorControlUnit.cost : 0) +
                    (extractorEnabled ? extractorHead.cost * 10 : 0);

                $('#buildCost')
                    .text(`${buildCost.toLocaleString('en-US')} ISK`)
                    .append(
                        `<small class="text-muted"> ({{ trans('seat-pi::templates.configurator.cost') }})</small>`
                    );

                const availablePowerCpu = $('#availablePowerCpu').text(`${powerRemaining} MW / ${cpuRemaining} TF`);
                if (powerRemaining < 0 || cpuRemaining < 0) {
                    availablePowerCpu.append(
                        $('<span></span>')
                        .html('&nbsp;<i class="fa fa-exclamation-triangle"></i>')
                        .addClass('text-danger')
                    );
                }
                availablePowerCpu.append(
                    `<small class="text-muted"> ({{ trans('seat-pi::templates.configurator.remaining') }})</small>`
                );

                $('#usedPowerCpu')
                    .text(`${powerConsumed} MW / ${cpuConsumed} TF`)
                    .append(
                        `<small class="text-muted"> ({{ trans('seat-pi::templates.configurator.used') }})</small>`
                    );
            }

            /**
             * Highlight the table row based on the planet ID.
             * 
             * @param {number} characterId The character ID to highlight.
             * @param {number} planetId The planet ID to highlight.
             * @returns {void}
             */
             const highlightTableRow = (characterId, planetId) => {
                const table = $('#planetOverviewTable').DataTable();
                table.rows().every(function() {
                    const row = $(this.node());
                    const rowCharacterId = row.data('character-id');
                    const rowPlanetId = row.data('planet-id');

                    if (
                        characterId && planetId &&
                        rowCharacterId === characterId &&
                        rowPlanetId === planetId
                    ) {
                        row.addClass('table-active');
                    } else {
                        row.removeClass('table-active');
                    }
                });
            }

            // Trigger updates when any of the fields change.
            $('#character').on('change', updateConfigurator);
            $('#productType').on('change', function() {
                highlightTableRow(null, null);
                updateConfigurator();
            });

            $('#commandCenterLevel').on('change', function() {
                updateConfiguratorCpuPowerProvided.call(this);
                updateConfiguratorConsumption();
            });
            $('#factories').on('change', function() {
                updateConfiguratorFactoryPowerRequired.call(this);
                updateConfiguratorConsumption();
            });

            $('#extractor').on('change', function() {
                $('#extractorWarning').toggleClass('d-none', !this.checked);
                updateConfiguratorConsumption();
            });

            // Handle the copy and download button clicks.
            $('#copyButton').on('click', onCopyHandler);
            $('#downloadButton').on('click', onDownloadHandler);

            // Fire once when the page loads.
            highlightTableRow({{ request()->get('characterId') }}, {{ request()->get('planetId') }});
            updateConfigurator();
            updateConfiguratorConsumption();
        });
    </script>
@endpush

@section('seat-pi-content')
    @include('seat-pi::account.includes.templates')
@endsection
