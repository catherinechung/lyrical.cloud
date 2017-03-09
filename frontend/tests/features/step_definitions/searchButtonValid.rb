Given /^I am on (.*)$/ do |link|
    #visit('https://localhost:8081')
end

And /^I input (.*)$/ do |artist|
    fill_in 'automplete-1', :with => '/#{artist}'
end

When /^I click on (.*?)$/ do |button|
    click_button(button)
end
