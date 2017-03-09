Given /^I am on (.*)$/ do |link|
    visit link
end

When /^I click on (.*?)$/ do |button|
    click_button(button)
end

When /^I press (.*?)$/
  this is the enter key
end

Then /^I see page (.*?)$/ do |path|
	current_url.should == path
end
