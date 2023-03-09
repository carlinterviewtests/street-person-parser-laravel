<?php

namespace Tests\Unit;
use App\Services\CsvPersonParser;
use Tests\TestCase;

class CsvPersonParserTest extends TestCase
{
    private $csvPersonParser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->csvPersonParser = new CsvPersonParser();
    }

    /**
     * Test that the CSV parser can correctly parse a person's name in a specific format.
     */
    public function test_it_can_parse_person(): void
    {
        $people = $this->csvPersonParser->parse(['Mr John Bloggs']);
        $this->assertSame([
            'title' => 'Mr',
            'first_name' => 'John',
            'initial' => null,
            'last_name' => 'Bloggs'
        ], $people[0]);
    }

    /**
     * Test that the CSV parser can correctly parse a person's name with their initial included.
     */
    public function test_it_can_parse_persons_initial(): void
    {
        $people = $this->csvPersonParser->parse(['Mr F. Bloggs']);
        $this->assertSame([
            'title' => 'Mr',
            'first_name' => null,
            'initial' => 'F',
            'last_name' => 'Bloggs'
        ], $people[0]);
    }

    /**
     * Test that the CSV parser can correctly parse a two-part name where both people share the same last name.
     */
    public function test_it_can_parse_two_names_in_a_row(): void
    {

        $people = $this->csvPersonParser->parse(['Mr & Mrs Smith']);
        $this->assertSame([
            'title' => 'Mr',
            'first_name' => null,
            'initial' => null,
            'last_name' => 'Smith'
        ], $people[0]);

        $this->assertSame([
            'title' => 'Mrs',
            'first_name' => null,
            'initial' => null,
            'last_name' => 'Smith'
        ], $people[1]);
    }

    /**
     * Test that createPerson returns null for invalid input data.
     */
    public function testCreatePersonReturnsNullForInvalidData()
    {
        $result = $this->csvPersonParser->createPerson('John');

        $this->assertNull($result);
    }

    /**
     * Test that createPerson can correctly parse a name string with both first and last names.
     */
    public function testCreatePersonWithFirstAndLastName()
    {
        $parser = new CsvPersonParser();
        $name = 'Mr John Doe';
        $expectedOutput = [
            'title' => 'Mr',
            'first_name' => 'John',
            'initial' => null,
            'last_name' => 'Doe'
        ];
        $this->assertEquals($expectedOutput, $parser->createPerson($name));
    }

    /**
     * Test that the CSV parser can correctly filter out invalid data.
     */
    public function test_it_can_filter_invalid_data(): void
    {

        $people = $this->csvPersonParser->parse(['homeowner']);
        $this->assertCount(0,$people);
    }

    /**
     * Test that the detectTitle method returns true for a valid title.
     */
    public function testDetectTitleReturnsTrueForValidTitle()
    {
        $result = $this->csvPersonParser->detectTitle('Mrs');

        $this->assertTrue($result);
    }

    /**
     * Test it returns false for invalid title
     */
    public function testDetectTitleReturnsFalseForInvalidTitle()
    {
        $result = $this->csvPersonParser->detectTitle('Master');

        $this->assertFalse($result);
    }

    /**
     * Test it parses with multiple and mixed titles
     */
    public function testParseWithMultipleAndMixedTitles()
    {
        $parser = new CsvPersonParser();
        $input = ['Mr John Doe and Prof Jane Smith'];
        $expectedOutput = collect([
            [
                'title' => 'Mr',
                'first_name' => 'John',
                'initial' => null,
                'last_name' => 'Doe'
            ],
            [
                'title' => 'Prof',
                'first_name' => 'Jane',
                'initial' => null,
                'last_name' => 'Smith'
            ],
        ]);
        $this->assertEquals($expectedOutput, $parser->parse($input));
    }

}
